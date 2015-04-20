<?php get_header(); ?>

 <section id="primary" class="hfeed">
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 
 <section id="single-wrapper">

 <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
 <h1 class="entry-title"><?php the_title(); ?></h1>
 <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
 
 <div class="entry-meta entry-header">
 <?php edit_post_link( __('edit', 'estete'), '<span class="edit-post">[', ']</span>' ); ?>
 </div>
 <?php endif; ?>

 <div class="entry-content">
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'estete').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
 </div>

 </article>
 
 </section>
 
 <?php comments_template('', true); ?>

 <?php endwhile; endif; ?>
 
 </section>
 
<?php include( TEMPLATEPATH . '/sidebar-page.php' ); ?>

<?php get_footer(); ?>