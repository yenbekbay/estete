 <aside id="sidebar">
 
 <div id="popular-posts">
 <ul>
 <h3 class="widget-title">Популярные посты</h3>
 <?php
 function filter_where($where = '') {
 $where .= " AND post_date > '" . date('Y-m-d', strtotime('-360 days')) . "'";
 return $where;
 }
 add_filter('posts_where', 'filter_where');
 ?>
 <?php $popPosts = new WP_Query();
 $popPosts->query('showposts=5&v_sortby=views&v_orderby=rand');
 while ($popPosts->have_posts()) : $popPosts->the_post(); ?>
<li class="clearfix">
 <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
<div class="tab-thumb">
 <a href="<?php the_permalink();?>" class="thumb"><?php the_post_thumbnail('post-thumbnail',array('title' => "")); ?></a>
 </div>
 <?php } ?>
<h3 class="entry-title"><a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a></h3>
 <div class="entry-meta entry-header">
  <span class="published"><?php if( date('Yz') == get_the_time('Yz') ) {echo 'Сегодня';} else { the_time( get_option('date_format') );}; ?></span>
  <span class="meta-sep">I</span>
  <span class="comment-count"><?php comments_number('0', '1', '%'); ?></span>
  <span class="meta-sep"> | </span>
  <span class="views-count"><?php if(function_exists('the_views')) { the_views(); } ?></span>
  <span class="meta-sep"> | </span>
  <span class="votes-count"><?php $ThumbUpID = 'post_'.get_the_ID(); echo ThumbsUp::item($ThumbUpID)->votes_balance; ?></span>
 </div>
 </li>
 
 <?php endwhile; 
 remove_filter('posts_where', 'filter_where'); 
 wp_reset_query();
 ?>
</ul>
 </div>
 
 <div id="vk-groups">
 <div id="vk_groups"></div>
 <script type="text/javascript">
 VK.Widgets.Group("vk_groups", {mode: 0, width: "300", height: "290"}, 29566873);
 </script>
 </div>
 
 <div id="facebook">
 <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Ffacebook.com%2Festete.net&amp;width=300&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23eee&amp;stream=false&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:258px;" allowTransparency="true"></iframe>
 </div>
 
 <div id="twitter-rss">
 <div class="twitter-follow">
 <a href="https://twitter.com/estete_net" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @estete_net</a>
 <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
 </div>
 <div class="rss-sidebar"><div class="rss-image"></div><a class="rss-link" href="http://estete.net/feed">Подписаться на RSS</a></div>
 </div>
 
 <div id="rand-posts">
 <?php
 query_posts('showposts=5&orderby=rand');
 if ( have_posts() ) : while ( have_posts() ) : the_post();
 ?>
 
 <div class="overlay_text overlay_top_bottom">
 <?php the_post_thumbnail('thumbnail-random',array('title' => "")); ?>
 <div class="overlay_text_mask black_mask">
 <h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
 <p>
  <span class="author"><?php the_author_posts_link(); ?></span>
  <span class="meta-sep hide"> | </span>
  <span class="published"><?php if( date('Yz') == get_the_time('Yz') ) {echo 'Сегодня';} else { the_time( get_option('date_format') );}; ?></span>
  <span class="meta-sep"> | </span>
  <span class="entry-categories"><?php the_category(', ') ?></span>
 </div> 
 </div> 
 <?php 
 endwhile;
 endif;
 ?>
</div>
 
 </aside>