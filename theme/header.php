<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>"/>
<meta name="robots" content="index, follow"/>
<?php e_meta_desc(); ?>
<?php
 $postTags = get_the_tags();
 $tagNames = array();
 foreach($postTags as $tag) {
 $tagNames[] = $tag->name;
 }
?>
<meta name="keywords" content="<?php if(is_home() || is_page()) {echo ('фото,арт,дизайн,креатив,фотографии,видео,короткометражки,пейзаж,портрет,морские пейзажи,зимний пейзаж,красивые пейзажи,живопись пейзаж,фото пейзажи,пейзажи картины,картинки пейзажи,пейзажи природы,городские пейзажи,красивые фото,фото на пляже,красивые фотографии,красивые фото,фотографии людей фото,сайты фотографов,фотографии профессионалов,профессиональные фотографии,фотографий,фотографии природы,фотографы,видеоклипы');} else {echo implode($tagNames,",");}?>"/>
<meta name="google-site-verification" content="iBxwc7mhKKg1Mw_SBlWEvXtu3pF4kQ7uVcWriwEJfSs"/>
<meta name="yandex-verification" content="4e8297385fd9a62f"/>
 
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico"/>
<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/images/icon.png"/>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/> 
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all"/>
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie.css" type="text/css" media="all"/>
<![endif]-->
<!--[if lte IE 8]>
<script src="<?php bloginfo('template_directory'); ?>/js/html5.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/respond.min.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://userapi.com/js/api/openapi.js?34"></script>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments ?>
<?php wp_head(); ?>
<script>
 VK.init({apiId: 2447653, onlyWidgets: true});
</script>
<script src="//yandex.st/share/share.js" charset="utf-8"></script> 
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script src="https://apis.google.com/js/plusone.js">
  {lang: 'ru'}
</script>
<script src="<?php bloginfo('template_directory'); ?>/thumbsup/init.min.js.php"></script>
</head>

<body <?php body_class(); ?>>
 <div id="container"> 
 <header id="header" class="clearfix"> 
 
 <div id="logo"> 
  <a href="http://estete.net"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="" width="180" height="60"/></a>
 </div>
 
 <nav id="primary-nav"> 
  <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'menu_id' => 'menu-categories', 'items_wrap' => '<ul id="%1$s" class="%2$s">'."\n".'  %3$s</ul>'."\n", 'walker' => new Cleaner_Walker_Nav_Menu() )); ?>
 </nav>
 
 <div id="header-login"> 
 <?php if (!(current_user_can('level_0'))){ ?>
 <form action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
  <a href="/wp-login.php" class="simplemodal-login"><strong>Войти</strong></a>
  <span>или</span>
  <a href="/wp-login.php?action=register" class="simplemodal-register">Зарегистрироваться</a>
  </form>
 </div>
  <?php } else { ?> 
  <div id="logged-in-menu">
  <a href="<?php echo get_option('home'); ?>/wp-admin/">
  <strong><?php
  global $current_user;
  if ( isset($current_user) ) {
  echo $current_user->user_login;
  } ?></strong> 
  </a><span class="slash">/</span>
  <a href="<?php echo wp_logout_url( home_url() ); ?>">Выйти</a>
  </div>
 </div>  
 <?php }?>
 
 <div id="search-header">
 <?php get_search_form(); ?>
 </div>
 
 </header>
 
 <section id="content" class="clearfix"> 