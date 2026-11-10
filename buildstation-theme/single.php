<?php
/**
 * The template for displaying all single posts
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}

// Ensure hello-world immediately redirects to YouTube Shorts
if (get_post_field('post_name') === 'hello-world' || get_the_ID() === 1) {
    wp_redirect('https://www.youtube.com/@BuildstationHQ/shorts', 301);
    exit;
}

get_header();
?>

<main id="top">
  <article class="bs-article">
    <?php while (have_posts()) : the_post(); ?>
      <header class="bs-article-header">
        <a href="<?php echo esc_url(home_url('/#videos')); ?>" style="font-family: var(--font-mono); font-size: 13px; color: var(--text-dim); display: inline-block; margin-bottom: 20px;">
          <?php esc_html_e('← back to benchmarks', 'buildstation'); ?>
        </a>

        <h1><?php the_title(); ?></h1>

        <div class="bs-article-meta">
          <span><?php echo get_the_date(); ?></span>
          <span>&bull;</span>
          <span><?php echo get_the_author(); ?></span>
          <?php if (has_category()) : ?>
            <span>&bull;</span>
            <span><?php the_category(', '); ?></span>
          <?php endif; ?>
        </div>
      </header>

      <?php if (has_post_thumbnail()) : ?>
        <div style="margin-bottom: 40px; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--grid);">
          <?php the_post_thumbnail('large', array('style' => 'width:100%;height:auto;display:block;')); ?>
        </div>
      <?php endif; ?>

      <div class="bs-article-content">
        <?php the_content(); ?>
      </div>

      <footer style="margin-top: 64px; padding-top: 32px; border-top: 1px solid var(--grid); display: flex; justify-content: space-between; align-items: center; font-family: var(--font-mono); font-size: 14px;">
        <div>
          <?php previous_post_link('%link', '← %title'); ?>
        </div>
        <div>
          <?php next_post_link('%link', '%title →'); ?>
        </div>
      </footer>
    <?php endwhile; ?>
  </article>
</main>

<?php
get_footer();
