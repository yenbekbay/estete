<?php get_header(); ?>
 
 <section id="primary" class="hfeed">
 <?php if (have_posts()) : ?>

 <h1 class="page-title"><?php _e('Search Results for', 'estete') ?>  <i><span style="color: #444; background-color: #eee;"><?php the_search_query(); ?><span></i>:</h1>

 <?php while (have_posts()) : the_post(); ?>

 <article <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
 <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php get_the_title()); ?>"> <?php the_title(); ?></a></h2>
 
 <div class="entry-meta entry-header">
  <span class="author"><?php the_author_posts_link(); ?></span>
  <span class="meta-sep"> | </span> 
  <span class="published"><?php if( date('Yz') == get_the_time('Yz') ) {echo 'Сегодня';} else { the_time( get_option('date_format') );}; ?></span>
  <span class="meta-sep"> | </span>
  <span class="entry-categories"><?php the_category(', ') ?></span>
  <span class="meta-sep"> | </span>
  <span class="comment-count"><?php comments_number('0', '1', '%'); ?></span>
  <span class="meta-sep"> | </span>
  <span class="views-count"><?php if(function_exists('the_views')) { the_views(); } ?></span>
  <span class="meta-sep"> | </span>
  <span class="votes-count"><?php $ThumbUpID = 'post_'.get_the_ID(); echo ThumbsUp::item($ThumbUpID)->votes_balance; ?></span>
 <?php edit_post_link( __('edit', 'estete'), '<span class="edit-post">[', ']</span>' ); ?>
 </div>
 
 <?php
 if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
 <div class="post-thumb">
  <a title="<?php get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail-lead',array('title' => ""));?></a>
 </div>
 <?php } ?>
 
 <div class="entry-summary">
  <?php the_excerpt(); ?>
 </div>
 
 </article>

 <?php endwhile; ?>

 <nav class="navigation page-navigation">
 <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
  <div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'estete')) ?></div>
  <div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'estete')) ?></div>
 <?php } ?>
 </nav>
 <?php else : ?>
 
 <h1 class="page-title"><?php _e('Your search did not match any entries','estete') ?></h1 >
 
 <article id="post-0">

 <div class="entry-content">
  <p><?php __('Try more general keywords', 'estete') ?></p>
 <?php get_search_form(); ?>
 </div>

 </article>

 <?php endif; ?>
 </section>

<?php include( TEMPLATEPATH . '/sidebar-page.php' ); ?>

<?php get_footer(); ?>