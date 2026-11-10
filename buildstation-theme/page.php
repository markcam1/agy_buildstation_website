<?php
/**
 * The template for displaying all pages
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="top">
  <article class="bs-article">
    <?php while (have_posts()) : the_post(); ?>
      <header class="bs-article-header">
        <h1><?php the_title(); ?></h1>
      </header>

      <div class="bs-article-content">
        <?php the_content(); ?>
      </div>
    <?php endwhile; ?>
  </article>
</main>

<?php
get_footer();
