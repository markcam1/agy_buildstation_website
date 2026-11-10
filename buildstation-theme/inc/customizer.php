<?php
/**
 * Buildstation Theme Customizer
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}

function buildstation_customize_register($wp_customize) {
    // Buildstation Settings Panel
    $wp_customize->add_panel('buildstation_panel', array(
        'title'       => __('Buildstation Settings', 'buildstation'),
        'description' => __('Configure hardware test bench and channel links.', 'buildstation'),
        'priority'    => 30,
    ));

    // Section: Hardware Test Bench
    $wp_customize->add_section('buildstation_testbench_section', array(
        'title'    => __('Hardware Test Bench', 'buildstation'),
        'panel'    => 'buildstation_panel',
        'priority' => 10,
    ));

    $bench_defaults = array(
        'cpu' => 'i7-14700KF',
        'gpu' => 'RTX 4060 Ti · 16GB',
        'ram' => '64GB DDR5',
        'os'  => 'Ubuntu 24.04',
    );

    foreach ($bench_defaults as $key => $default) {
        $wp_customize->add_setting("buildstation_spec_{$key}", array(
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("buildstation_spec_{$key}", array(
            'label'    => sprintf(__('Spec: %s', 'buildstation'), strtoupper($key)),
            'section'  => 'buildstation_testbench_section',
            'type'     => 'text',
        ));
    }

    // Section: Social & Channel Links
    $wp_customize->add_section('buildstation_links_section', array(
        'title'    => __('Channel & Social Links', 'buildstation'),
        'panel'    => 'buildstation_panel',
        'priority' => 20,
    ));

    $link_fields = array(
        'youtube_url'   => array('label' => __('YouTube Channel URL', 'buildstation'), 'default' => 'https://www.youtube.com/@BuildstationHQ/shorts'),
    );

    foreach ($link_fields as $key => $field) {
        $wp_customize->add_setting("buildstation_{$key}", array(
            'default'           => $field['default'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("buildstation_{$key}", array(
            'label'    => $field['label'],
            'section'  => 'buildstation_links_section',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'buildstation_customize_register');
