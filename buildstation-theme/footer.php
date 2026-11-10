<?php
/**
 * The template for displaying the footer
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<footer class="bs-footer">
  <div class="bs-footer-inner">
    <div class="bs-footer-top">
      <div style="flex: 1 1 280px; display: flex; flex-direction: column; gap: 12px">
        <span style="font-family: var(--font-head); font-weight: 900; font-size: 28px; letter-spacing: -0.02em; color: var(--text)">Buildstation</span>
        <span style="font-family: var(--font-hand); font-weight: 700; font-size: 24px; color: var(--text-dim)"><?php esc_html_e('measured on the machine you own', 'buildstation'); ?></span>
      </div>
      <div class="bs-footer-links-group">
        <div class="bs-footer-col">
          <span class="bs-footer-heading"><?php esc_html_e('channel', 'buildstation'); ?></span>
          <a href="<?php echo esc_url(home_url('/#videos')); ?>" class="bs-link"><?php esc_html_e('Videos', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#method')); ?>" class="bs-link"><?php esc_html_e('Method', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#about')); ?>" class="bs-link"><?php esc_html_e('About', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#hardware')); ?>" class="bs-link"><?php esc_html_e('Hardware Rig', 'buildstation'); ?></a>
        </div>
        <div class="bs-footer-col">
          <span class="bs-footer-heading"><?php esc_html_e('explore', 'buildstation'); ?></span>
          <a href="<?php echo esc_url(home_url('/how-swe-bench-actually-scores-ai-models/')); ?>" class="bs-link"><?php esc_html_e('SWE-bench Deep Dive', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#dispatch')); ?>" class="bs-link"><?php esc_html_e('Benchmark Dispatch', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#harnesses')); ?>" class="bs-link"><?php esc_html_e('Harnesses', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#privacy')); ?>" class="bs-link"><?php esc_html_e('On-Prem Privacy', 'buildstation'); ?></a>
          <a href="<?php echo esc_url(home_url('/#subscribe')); ?>" class="bs-link"><?php esc_html_e('Newsletter', 'buildstation'); ?></a>
        </div>
        <div class="bs-footer-col">
          <span class="bs-footer-heading"><?php esc_html_e('follow', 'buildstation'); ?></span>
          <a href="<?php echo esc_url(buildstation_get_link('youtube_url', 'https://www.youtube.com/@BuildstationHQ/shorts')); ?>" target="_blank" rel="noopener" class="bs-link">YouTube</a>
        </div>
      </div>
    </div>
    <div class="bs-footer-bottom">
      <span>&copy; <?php echo date('Y'); ?> Buildstation &middot; SimpleInvest Digital LLC. <?php esc_html_e('All rights reserved.', 'buildstation'); ?></span>
      <span style="max-width: 640px"><?php esc_html_e('Content is educational and informational research on local developer tooling and open-weight models, published by SimpleInvest Digital LLC. Tests reflect measurements on one consumer hardware rig. Your hardware, drivers and environment will change the numbers.', 'buildstation'); ?></span>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
