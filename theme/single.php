<?php get_header(); ?>

 <section id="primary" class="hfeed">
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 
 <section id="single-wrapper">
 
 <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
 <h1 class="entry-title"><?php the_title(); ?></h1>
 
 <div class="entry-meta entry-header">
  <span class="author"><?php the_author_posts_link(); ?></span>
  <span class="meta-sep"> | </span>
  <span class="published"><?php if( date('Yz') == get_the_time('Yz') ) {echo 'Сегодня';} else { the_time( get_option('date_format') );}; ?></span>
  <span class="meta-sep"> | </span>
  <span class="entry-categories"><?php the_category(', ') ?></span>
 <?php edit_post_link( __('edit', 'estete'), '<span class="edit-post">[', ']</span>' ); ?> 
 </div>
 
 <div class="entry-meta1">
  <span class="comment-count"><?php comments_number('0', '1', '%'); ?></span>
  <span class="meta-sep"> | </span>
  <span class="views-count"><?php if(function_exists('the_views')) { the_views(); } ?></span>
  <span class="meta-sep"> | </span>
  <span class="votes-count"><?php $ThumbUpID = 'post_'.get_the_ID(); echo ThumbsUp::item($ThumbUpID)->votes_balance; ?></span>
 
  <div id="social_button-top">
  <noindex>

  <div id="bt_vk">
  <div id="vk_like-1"></div>
  <script type="text/javascript">
  VK.Widgets.Like("vk_like-1", {type: "mini"});
  </script>
  </div>

  <div id="bt_twitter">
  <a href="http://twitter.com/share" class="twitter-share-button" data-via="estete_net" data-lang="en">>Tweet</a>
  </div>
 
  <div id="bt_plusone">
  <div class="g-plusone" data-size="medium" data-href="<?php the_permalink() ?>"></div>
  </div>
 
  <div id="bt_facebookr">
  <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;layout=button_count&amp;show_faces=true&amp;width=82&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21&amp;locale=en_US" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:82px; height:21px;" allowTransparency="true"></iframe>
  </div>
 
  </noindex>
  </div> 
  
 </div> 
 
 <?php if ($e_insert_image == "true") { ?>
 <?php 
 if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
 <div class="post-thumb-single">
 <?php the_post_thumbnail('thumbnail-lead',array('title' => "")); ?>
 </div>
 <?php } } ?>
 
 <div class="entry-content">
  <?php the_content(); ?> 
  
 <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'estete').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
 
 <div id="tags">
  <span class="tags"><strong>Теги:</strong></span> <?php the_tags('', ', ', ''); ?>
 
 </div>
 
 <div class="thumbsup-single">
 <?php $ThumbUpID = 'post_'.get_the_ID(); echo ThumbsUp::item($ThumbUpID)->template('up_down')->options('align=right'); ?>
 </div>
 
 </div> 
 
 <div id="social_button-bottom">
 <noindex>
 
 <div id="bt_vk">
 <div id="vk_like-2"></div>
 <script type="text/javascript">
 VK.Widgets.Like("vk_like-2", {type: "mini"});
 </script>
 </div>

 <div id="bt_twitter">
 <a href="http://twitter.com/share" class="twitter-share-button" data-via="estete_net" data-lang="en">Tweet</a>
 </div>
 
 <div id="bt_plusone">
 <div class="g-plusone" data-size="medium" data-href="<?php the_permalink() ?>"></div>
 </div>

 <div id="bt_facebookr">
 <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;layout=button_count&amp;show_faces=true&amp;width=82&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21&amp;locale=en_US" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:82px; height:21px;" allowTransparency="true"></iframe>
 </div>

 <div id="yandex_share">
 <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
 <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,moimir,lj"></div> 
 </div>

 </noindex>
 </div> 
 
 <div id="related-posts" class="clearfix"> 
 <?php
 $backup = $post;
 $categories = get_the_category($post->ID);
 if ($categories) {
 $category_ids = array();
 foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
 
 $args=array(
 'category__in' => $category_ids,
 'post__not_in' => array($post->ID),
 'showposts'=> 4,
 'orderby'=> rand,
 'caller_get_posts'=>1
 );
 $related_posts = new wp_query($args);
 if( $related_posts->have_posts() ) { ?>
 
 <h3 class="widget-title">Интересные посты:</h3> 
 <?php while ($related_posts->have_posts()) {
 $related_posts->the_post();?>
 
 <div class="post-container">
 
 <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
<div class="overlay_zoom">
  <?php the_post_thumbnail('thumbnail-related',array('title' => "")); ?>
 <div class="overlay_zoom_mask">
  <a class="zoom_link" href="<?php the_permalink(); ?>"></a>
 </div> 
 </div> 
 
 <div class="post-title"> 
  <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
 </div>
 <?php } ?>

 </div>
 <?php
 }
 }
 }
 $post = $backup;
 wp_reset_query();
 ?>
 
 </div>
 
 </article>
 
 <nav class="post-navigation clearfix">
 <?php
 $prev_post = get_adjacent_post(false, '', true);
 $next_post = get_adjacent_post(false, '', false); ?>
 <?php if ($prev_post) : $prev_post_url = get_permalink($prev_post->ID); $prev_post_title = $prev_post->post_title; ?>
  <a class="post-prev" href="<?php echo $prev_post_url; ?>"><em>Предыдущий пост</em><span><?php echo $prev_post_title; ?></span></a>
 <?php endif; ?>
 <?php if ($next_post) : $next_post_url = get_permalink($next_post->ID); $next_post_title = $next_post->post_title; ?>
  <a class="post-next" href="<?php echo $next_post_url; ?>"><em>Следующий пост</em><span><?php echo $next_post_title; ?></span></a>
<?php endif; ?>
</nav>
 
 </section>
 
 <?php comments_template('', true); ?>
 
 <?php endwhile; else: ?>
 
 <article id="post-0" <?php post_class() ?>>
 
 <h1 class="entry-title"><?php _e('Error 404 - Not Found', 'estete') ?></h1>
 
 <div class="entry-content">
  <p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
 <?php get_search_form(); ?>
 </div>
 
 </article>
 
 <?php endif; ?>
</section>

<?php include( TEMPLATEPATH . '/sidebar-single.php' ); ?>

<?php get_footer(); ?>