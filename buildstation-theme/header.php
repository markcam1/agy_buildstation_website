<?php
/**
 * The header for Buildstation theme
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bs-header">
  <div class="bs-header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="bs-logo">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <span>Buildstation</span>
        <span class="bs-logo-pill">16GB</span>
      <?php endif; ?>
    </a>

    <?php if (has_nav_menu('primary')) : ?>
      <nav class="bs-navlinks" aria-label="<?php esc_attr_e('Primary', 'buildstation'); ?>">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
        ));
        ?>
      </nav>
    <?php else : ?>
      <nav class="bs-navlinks" aria-label="<?php esc_attr_e('Primary', 'buildstation'); ?>">
        <a href="<?php echo esc_url(home_url('/#videos')); ?>" class="bs-link">videos</a>
        <a href="<?php echo esc_url(home_url('/how-swe-bench-actually-scores-ai-models/')); ?>" class="bs-link">articles</a>
        <a href="<?php echo esc_url(home_url('/#dispatch')); ?>" class="bs-link">dispatch</a>
        <a href="<?php echo esc_url(home_url('/#method')); ?>" class="bs-link">method</a>
        <a href="<?php echo esc_url(home_url('/#harnesses')); ?>" class="bs-link">harnesses</a>
        <a href="<?php echo esc_url(home_url('/#about')); ?>" class="bs-link">about</a>
        <a href="<?php echo esc_url(home_url('/#privacy')); ?>" class="bs-link">privacy</a>
        <a href="<?php echo esc_url(home_url('/#hardware')); ?>" class="bs-link">rig</a>
      </nav>
    <?php endif; ?>

    <div class="bs-header-actions">
      <a href="<?php echo esc_url(home_url('/#subscribe')); ?>" class="bs-btn bs-btn-outline bs-header-subscribe-btn" style="min-height: 40px; padding: 8px 16px; font-size: 13px;">subscribe</a>
      <button class="bs-menu-toggle" aria-label="<?php esc_attr_e('Toggle navigation', 'buildstation'); ?>" aria-expanded="false">[ menu ]</button>
    </div>
  </div>

  <!-- Mobile Drawer -->
  <div class="bs-mobile-drawer">
    <a href="<?php echo esc_url(home_url('/#videos')); ?>"><?php esc_html_e('// 04 videos', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/how-swe-bench-actually-scores-ai-models/')); ?>" style="color: var(--accent);"><?php esc_html_e('// deep dive: swe-bench', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#dispatch')); ?>"><?php esc_html_e('// 06 dispatch', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#method')); ?>"><?php esc_html_e('// 02 method', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#harnesses')); ?>"><?php esc_html_e('// the niche', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#about')); ?>"><?php esc_html_e('// 01 problem', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#process')); ?>"><?php esc_html_e('// 03 process', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#privacy')); ?>"><?php esc_html_e('// 05 privacy', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#hardware')); ?>"><?php esc_html_e('// under the hood', 'buildstation'); ?></a>
    <a href="<?php echo esc_url(home_url('/#subscribe')); ?>" style="color: var(--urgent); font-weight: 700;"><?php esc_html_e('→ subscribe for benchmarks', 'buildstation'); ?></a>
  </div>
</header>
