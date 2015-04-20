<?php

 if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
 die ('Please do not load this page directly. Thanks!');

 if ( post_password_required() ) { ?>
 <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'estete') ?></p>
 <?php
 return;
 }
?>

 <section id="comment-wrapper">
 
 <?php if ( have_comments() ) : // if there are comments ?> 
 
 <?php if ( ! empty($comments_by_type['comment']) ) : // if there are normal comments ?>
 
 <h3 id="comments" class="widget-title"><?php plural_form( get_comments_number(), array('комментарий','комментария','комментариев'));?></h3>
 
 <ol class="commentlist">
 <?php wp_list_comments('type=comment&avatar_size=50'); ?>
 </ol>

 <?php endif; ?>

 <?php if ( ! empty($comments_by_type['pings']) ) : // if there are pings ?>
 
 <h3 id="pings" class="widget-title"><?php _e('Trackbacks for this post', 'estete') ?></h3>
 
 <ol class="pinglist">
 <?php wp_list_comments('type=pings&callback=e_list_pings'); ?>
 </ol>

 <?php endif; ?>
 
 <div class="navigation">
 <div class="alignleft"><?php previous_comments_link(); ?></div>
 <div class="alignright"><?php next_comments_link(); ?></div>
 </div>
 
 <?php if ('closed' == $post->comment_status ) : // if the post has comments but comments are now closed ?>
 <p class="nocomments"><?php _e('Comments are now closed for this article.', 'estete') ?></p>
 <?php endif; ?>

 <?php else : ?>
 
 <?php if ('open' == $post->comment_status) : // if comments are open but no comments so far ?>

 <?php else : // if comments are closed ?>
 
 <?php if (is_single()) { ?><p class="nocomments"><?php _e('Comments are closed.', 'estete') ?></p><?php } ?>

 <?php endif; ?>
 
<?php endif; ?>

 <?php if ( comments_open() ) : ?>
 <div id="respond">

 <h3 class="widget-title"><?php comment_form_title( __('Leave a Reply', 'estete'), __('Leave a Reply to %s', 'estete') ); ?></h3>
 
 <div class="cancel-comment-reply">
 <?php cancel_comment_reply_link(); ?>
 </div>
 
 <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
 <p><?php printf(__('You must be %1$slogged in%2$s to post a comment.', 'estete'), '<a href="'.get_option('siteurl').'/wp-login.php?redirect_to='.urlencode(get_permalink()).'">', '</a>') ?></p>
 <?php else : ?>
 
 <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
 
 <?php if ( is_user_logged_in() ) : ?>
 
 <p><?php printf(__('Logged in as %1$s. %2$sLog out &raquo;%3$s', 'estete'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>', '<a href="'.(function_exists('wp_logout_url') ? wp_logout_url(get_permalink()) : get_option('siteurl').'/wp-login.php?action=logout" title="').'" title="'.__('Log out of this account', 'estete').'">', '</a>') ?></p>
 
<?php else : ?>
<div id="comments-aware"><a href="/wp-login.php" class="simplemodal-login"><strong>Авторизуйтесь</strong></a> или <a href="/wp-login.php?action=register" class="simplemodal-register"><strong>зарегистрируйтесь</strong></a>, чтобы не заполнять форму.</div> 
 
 <div class="inputs">
 <input type="text" name="author" id="author" onfocus="if(this.value=='Имя*') this.value='';" value="Имя*" size="22" tabindex="1" /> 
 <input type="text" name="email" id="email" onfocus="if(this.value=='Email*') this.value='';" value="Email*" size="22" tabindex="2" />
 <input type="text" name="url" id="url" onfocus="if(this.value=='Сайт') this.value='';" value="Сайт" size="22" tabindex="3" />
 </div>
 
<?php endif; ?>
<p><textarea name="comment" id="comment" cols="58" tabindex="4"></textarea></p>
 
 <!--<p class="allowed-tags"><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
 
 <p><input name="submit" type="submit" id="submit" tabindex="5" value="Отправить" />
 <?php comment_id_fields(); ?>
 </p>
 <?php do_action('comment_form', $post->ID); ?>
 
 </form>

 <?php endif; // If registration required and not logged in ?>
 </div>
  <?php endif; // if you delete this the sky will fall on your head ?>
 
 </section>