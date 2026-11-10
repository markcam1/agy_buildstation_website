<?php
/**
 * Buildstation Theme Functions & Definitions
 *
 * @package Buildstation
 * @version 1.0.7
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include Customizer settings
require_once get_template_directory() . '/inc/customizer.php';

/**
 * 301 Redirects: Hello World to YouTube Shorts
 */
function buildstation_custom_redirects() {
    $request_uri = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if ($request_uri === 'hello-world' || is_single('hello-world') || (is_single() && get_the_ID() === 1)) {
        wp_redirect('https://www.youtube.com/@BuildstationHQ/shorts', 301);
        exit;
    }
}
add_action('template_redirect', 'buildstation_custom_redirects', 1);

/**
 * Theme Setup
 */
function buildstation_setup() {
    // Let WordPress manage document title
    add_theme_support('title-tag');

    // Enable featured images for posts
    add_theme_support('post-thumbnails');

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Gutenberg wide alignment support
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Navigation Menu', 'buildstation'),
        'footer'  => __('Footer Navigation Menu', 'buildstation'),
    ));
}
add_action('after_setup_theme', 'buildstation_setup');

/**
 * Enqueue scripts and styles
 */
function buildstation_scripts() {
    // Google Fonts strictly matching Buildstation Style Guide
    // Poppins (600, 800, 900), Roboto Mono (500, 700), Inter (400, 500, 600), Caveat (500, 700)
    wp_enqueue_style(
        'buildstation-fonts',
        'https://fonts.googleapis.com/css2?family=Caveat:wght@500;700&family=Inter:wght@400;500;600&family=Poppins:wght@600;800;900&family=Roboto+Mono:wght@500;700&display=swap',
        array(),
        null
    );

    // Theme stylesheet with cache-busting timestamp
    wp_enqueue_style(
        'buildstation-style',
        get_stylesheet_uri(),
        array('buildstation-fonts'),
        '1.0.7'
    );

    // Theme JavaScript
    wp_enqueue_script(
        'buildstation-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.7',
        true
    );

    // Pass AJAX configuration to script
    wp_localize_script('buildstation-js', 'buildstation_ajax', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('buildstation_subscribe_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'buildstation_scripts');

/**
 * Robust Newsletter Subscription Handler
 * Supports both AJAX and standard HTML POST fallback (admin-post.php)
 * Handles cached nonces gracefully with bot honeypot protection
 */
function buildstation_process_subscription() {
    // Honeypot check: If hidden field is filled, silently ignore bot
    if (!empty($_POST['bs_hp'])) {
        if (wp_doing_ajax() || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            wp_send_json_success(array('message' => __('Subscribed! One email per video, zero spam.', 'buildstation')));
        } else {
            wp_safe_redirect(home_url('/#subscribe?subscribed=1'));
            exit;
        }
    }

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (!is_email($email)) {
        if (wp_doing_ajax() || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            wp_send_json_error(array('message' => __('Please enter a valid email address.', 'buildstation')));
        } else {
            wp_safe_redirect(home_url('/#subscribe?error=invalid_email'));
            exit;
        }
    }

    // Save subscriber to WP options array with timestamp
    $subscribers = get_option('buildstation_subscribers', array());
    if (!is_array($subscribers)) {
        $subscribers = array();
    }

    $exists = false;
    foreach ($subscribers as $entry) {
        if (is_array($entry) && isset($entry['email']) && strtolower($entry['email']) === strtolower($email)) {
            $exists = true;
            break;
        } elseif (is_string($entry) && strtolower($entry) === strtolower($email)) {
            $exists = true;
            break;
        }
    }

    if (!$exists) {
        $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
        $subscribers[] = array(
            'email' => $email,
            'date'  => current_time('mysql'),
            'ip'    => $ip,
        );
        update_option('buildstation_subscribers', $subscribers, false);

        // Notify site administrator via email
        $admin_email = get_option('admin_email');
        if ($admin_email) {
            $subject = sprintf(__('New Buildstation Subscriber: %s', 'buildstation'), $email);
            $message = sprintf(
                "A new user subscribed to Buildstation benchmark updates:\n\nEmail: %s\nDate: %s\nIP: %s\n\nYou can view and export all subscribers from your WordPress dashboard under Subscribers.",
                $email,
                current_time('mysql'),
                $ip
            );
            wp_mail($admin_email, $subject, $message);
        }
    }

    if (wp_doing_ajax() || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) || isset($_POST['is_ajax'])) {
        wp_send_json_success(array('message' => __('Subscribed! One email per video, zero spam.', 'buildstation')));
    } else {
        $redirect_to = wp_get_referer();
        if (!$redirect_to) {
            $redirect_to = home_url('/#subscribe');
        }
        $redirect_to = add_query_arg('subscribed', '1', $redirect_to);
        wp_safe_redirect($redirect_to);
        exit;
    }
}
// AJAX hooks
add_action('wp_ajax_buildstation_subscribe', 'buildstation_process_subscription');
add_action('wp_ajax_nopriv_buildstation_subscribe', 'buildstation_process_subscription');
// Standard HTML form POST fallback hooks
add_action('admin_post_buildstation_subscribe', 'buildstation_process_subscription');
add_action('admin_post_nopriv_buildstation_subscribe', 'buildstation_process_subscription');

/**
 * Admin Menu: Subscribers List & CSV Export
 */
function buildstation_subscribers_admin_menu() {
    add_menu_page(
        __('Subscribers', 'buildstation'),
        __('Subscribers', 'buildstation'),
        'manage_options',
        'buildstation-subscribers',
        'buildstation_render_subscribers_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'buildstation_subscribers_admin_menu');

function buildstation_render_subscribers_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $raw_subscribers = get_option('buildstation_subscribers', array());
    // Normalize format
    $subscribers = array();
    if (is_array($raw_subscribers)) {
        foreach ($raw_subscribers as $s) {
            if (is_string($s)) {
                $subscribers[] = array('email' => $s, 'date' => '-');
            } elseif (is_array($s)) {
                $subscribers[] = $s;
            }
        }
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Buildstation Subscribers', 'buildstation'); ?></h1>
        <p><?php printf(esc_html__('Total subscribers: %d', 'buildstation'), count($subscribers)); ?></p>

        <?php if (!empty($subscribers)) : ?>
            <p style="margin-bottom: 20px;">
                <a href="<?php echo esc_url(admin_url('admin-post.php?action=buildstation_export_subscribers')); ?>" class="button button-primary">
                    <?php esc_html_e('Export to CSV', 'buildstation'); ?>
                </a>
            </p>
            <table class="widefat fixed striped" style="max-width: 800px;">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th><?php esc_html_e('Email Address', 'buildstation'); ?></th>
                        <th style="width: 180px;"><?php esc_html_e('Date Subscribed', 'buildstation'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $index => $item) : ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><strong><?php echo esc_html($item['email']); ?></strong></td>
                            <td><?php echo esc_html($item['date'] ?? '-'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="notice notice-info inline" style="padding: 12px; margin-top: 16px;">
                <p><?php esc_html_e('No subscribers yet. When visitors sign up on your homepage, their emails will appear here and trigger an email notification to your admin address.', 'buildstation'); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function buildstation_export_subscribers_csv() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Unauthorized', 'buildstation'));
    }

    $raw = get_option('buildstation_subscribers', array());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=buildstation_subscribers_' . date('Y-m-d') . '.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'Email', 'Date'));

    if (is_array($raw)) {
        foreach ($raw as $index => $item) {
            $email = is_array($item) ? ($item['email'] ?? '') : $item;
            $date  = is_array($item) ? ($item['date'] ?? '') : '';
            fputcsv($output, array($index + 1, $email, $date));
        }
    }
    fclose($output);
    exit;
}
add_action('admin_post_buildstation_export_subscribers', 'buildstation_export_subscribers_csv');

/**
 * Helper to get theme options with defaults
 */
function buildstation_get_spec($key, $default = '') {
    return get_theme_mod("buildstation_spec_{$key}", $default);
}

function buildstation_get_link($key, $default = '#') {
    if ($key === 'youtube_url' && $default === '#') {
        $default = 'https://www.youtube.com/@BuildstationHQ/shorts';
    }
    return get_theme_mod("buildstation_{$key}", $default);
}
