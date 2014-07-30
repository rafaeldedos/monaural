<?php /* Template Name: Inicio */ get_header(contato); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">
<h1 class="page-title"><?php the_title(); ?></h1>

<p>
	<strong>Rafael Jordão Trabasso</strong> <br>
	São José dos Campos / SP / Brasil <br>
</p>

<p></p>

<div class="contatos">
	
	<div class="social">
	<div class="fb-like-box" data-href="https://www.facebook.com/rafaeldedos" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
	</div>
	
	<div class="conteudo">
	<?php the_content();?>	
	</div>
	
</div>
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