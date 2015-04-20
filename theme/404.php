<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset=<?php bloginfo('charset'); ?>" />
 
<title>Страница не найдена | Estete</title>
<link rel="shortcut icon" href="http://estete.net/wp-content/themes/estete/favicon.ico" />
<link rel="stylesheet" href="http://estete.net/wp-content/themes/estete/css/error404.css" type="text/css" media="screen" />
</head>

 <body class="error404">
 <div id="content">
 
 <a id="logo" href="http://estete.net"><img src="<?php bloginfo('template_directory'); ?>/images/404-logo.png" border="0"></a>
 <div id="post-0">
 
 <h1 class="entry-title"><?php _e('Error 404 - Not Found', 'estete') ?></h1>
 
 <div class="entry-content">
 <p>Попробуйте найти её с помощью поиска или вернитесь <a href="javascript:history.back();">назад</a>.</p>
 <?php get_search_form(); ?>
 </div>
 
 
 </div>
 </div>
 </body>
</html>
