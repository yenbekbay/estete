<?php get_header(); 
 if(get_query_var('author_name')) :
 $curauth = get_userdatabylogin(get_query_var('author_name'));
 else :
 $curauth = get_userdata(get_query_var('author'));
 endif;
?>
 
 <section id="primary" class="hfeed">
 <?php if (have_posts()) :
 $post = $posts[0]; 
 ?>
 
  <h1 class="page-title">
  <?php if(is_category()) {
   printf(__('Category: %s', 'estete'), single_cat_title('',false));
  } elseif(is_tag()) {
   printf(__('Tag: %s', 'estete'), single_tag_title('',false));
  } elseif(is_tax('post_format')) {
   _e(get_post_format(), 'estete');
  } elseif(is_day()) {
   printf(__('Archive for %s', 'estete'), get_the_date('F j, Y'));
  } elseif(is_month()) {
   printf(__('Archive for %s', 'estete'), get_the_date('F, Y'));
  } elseif(is_year()) {
   printf(__('Archive for %s year', 'estete'), get_the_date('Y'));
  } elseif(is_author()) {
   _e('All posts by ', 'estete');
   echo $curauth->display_name;
  } else { 
   _e('Blog Archives', 'estete'); } ?>
  </h1>
 
 <?php while (have_posts()) : the_post(); ?> 
 
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
 
 <?php else :
 
 if ( is_category() ) { 
 printf(__('<h2>Sorry, but there aren\'t any posts in the %s category yet.</h2>', 'estete'), single_cat_title('',false));
 } else if ( is_date() ) { 
 echo(__('<h2>Sorry, but there aren\'t any posts with this date.</h2>', 'estete'));
 } else if ( is_author() ) { 
 $userdata = get_userdatabylogin(get_query_var('author_name'));
 printf(__('<h2>Sorry, but there aren\'t any posts by %s yet.</h2>', 'estete'), $userdata->display_name);
 } else {
 echo(__('<h2>No posts found.</h2>', 'estete'));
 }
 get_search_form();
 
 endif; ?>
 
 </section> 
 
<?php get_sidebar(); ?>

<?php get_footer(); ?>