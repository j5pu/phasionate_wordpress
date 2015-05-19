<?php
/**
	Template Name: Content Only
*/
?>
<html>
<head>
   <title><?php wp_title( '|', true, 'right' ); bloginfo('url'); ?></title>
   <style>
       html,body,div,iframe {height:100%;}
       p {position:relative;overflow:hidden;}
       iframe {border:none;width:100%;}
       body {margin:0;padding:0;overflow:hidden;}
   </style>
</head>

<body>
      <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); endwhile; ?> 
</body>
</html>