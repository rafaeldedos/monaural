<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">
<h1 class="page-title"><?php the_title(); ?></h1>
<?php the_content();?>
</section> 

</article>

<?php endwhile; else : ?>

<article id="post-not-found" class="hentry cf">
<header class="article-header">
<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
</header>
<section class="entry-content">
<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
</section>
<footer class="article-footer">
<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
</footer>
</article>

<?php endif; ?>

<?php get_footer(); ?>