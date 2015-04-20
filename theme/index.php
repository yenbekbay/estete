<?php get_header(); ?>
 
 <section id="primary" class="hfeed"> 
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 
 <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
 
 <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title=""><?php the_title(); ?></a></h2>
 
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
  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail-lead',array('title' => "")); ?></a>
 </div>
 <?php } ?>

 <div class="entry-content">
  <?php the_excerpt(); ?>
  
  <p class="more-link"><a href="<?php get_permalink($post->ID) ?>"><?php _e('Read more', 'estete') ?></a></p>

 <div class="thumbsup-index">
 <?php $ThumbUpID = 'post_'.get_the_ID(); echo ThumbsUp::item($ThumbUpID)->template('up_down')->options('align=right')->format('{+BALANCE}'); ?>
 </div>
 
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

 <article id="post-0" <?php post_class(); ?>>
 
 <h2 class="entry-title"><?php _e('Error 404 - Not Found', 'estete') ?></h2>
 
 <div class="entry-content">
 <p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
 <?php get_search_form(); ?>
 </div>
 
 </article>

 <?php endif; ?>
 </section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>