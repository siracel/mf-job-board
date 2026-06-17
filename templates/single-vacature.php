<?php
/**
 * Detailtemplate voor één vacature.
 *
 * Spiegelt de structuur van het MF-thema (single.php) zodat header,
 * page-banner (template-parts/post-title) en footer identiek meekomen,
 * MAAR vervangt template-parts/content-single door the_content().
 * Daardoor vervalt de standaard berichten-meta (auteur, datum, reacties)
 * en injecteert de plugin alleen de vacature-velden via the_content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<div class="content-main">
  <div id="primary" class="site-content">
    <div id="content" role="main">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/post-title' ); ?>
        <div class="container">
          <div class="row">
            <div class="col-12">
              <?php the_content(); // door de plugin verrijkt met subtitel, chips en sollicitatieblok ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <!-- #content -->
  </div>
  <!-- #primary -->
</div>
<?php get_footer(); ?>
