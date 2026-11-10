<?php
/**
 * The main template file (Archive / Blog listing)
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="top" style="padding: 64px 0 96px;">
  <div class="bs-container">
    <div style="margin-bottom: 48px;">
      <span class="bs-eyebrow"><?php esc_html_e('// benchmark archive', 'buildstation'); ?></span>
      <h1><?php single_post_title(); ?></h1>
      <p style="font-size: 18px; color: var(--text-dim); max-width: 640px;">
        <?php esc_html_e('Measured throughput, honest constraints, and reproducible test runs on consumer hardware.', 'buildstation'); ?>
      </p>
    </div>

    <?php if (have_posts()) : ?>
      <div class="bs-grid-3">
        <?php while (have_posts()) : the_post(); ?>
          <article class="bs-card">
            <?php if (has_post_thumbnail()) : ?>
              <div class="bs-video-thumb">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium_large', array('style' => 'width:100%;height:auto;display:block;border-radius:6px;')); ?>
                </a>
              </div>
            <?php endif; ?>

            <div style="display: flex; gap: 12px; align-items: center; font-family: var(--font-mono); font-size: 12px; color: var(--text-dim);">
              <span><?php echo get_the_date(); ?></span>
              <span>&bull;</span>
              <span><?php echo esc_html(get_the_category_list(', ')); ?></span>
            </div>

            <h2 class="bs-card-title">
              <a href="<?php the_permalink(); ?>" class="bs-link"><?php the_title(); ?></a>
            </h2>

            <div class="bs-card-desc">
              <?php the_excerpt(); ?>
            </div>

            <div style="margin-top: auto; padding-top: 16px;">
              <a href="<?php the_permalink(); ?>" style="font-family: var(--font-mono); font-weight: 700; font-size: 14px; color: var(--accent);">
                <?php esc_html_e('read full run →', 'buildstation'); ?>
              </a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div style="margin-top: 64px; text-align: center; font-family: var(--font-mono);">
        <?php
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('← newer', 'buildstation'),
            'next_text' => __('older →', 'buildstation'),
        ));
        ?>
      </div>
    <?php else : ?>
      <div class="bs-card" style="text-align: center; padding: 64px 24px;">
        <h2 style="margin-bottom: 12px;"><?php esc_html_e('No test runs published yet.', 'buildstation'); ?></h2>
        <p style="color: var(--text-dim);"><?php esc_html_e('New benchmarks will be published as soon as runs complete on the bench.', 'buildstation'); ?></p>
        <div style="margin-top: 24px;">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="bs-btn bs-btn-outline"><?php esc_html_e('← return to homepage', 'buildstation'); ?></a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();
