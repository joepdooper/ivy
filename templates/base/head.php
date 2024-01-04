<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>
<!-- <meta charset="utf-8"> -->
<meta http-equiv="Content-type" content="text/html;charset=ENCODING">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0">
<!-- <meta http-equiv="Content-Security-Policy" content="script-src 'none'"> -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="<?php print $info['name']->value; ?>">
<meta name="theme-color" content="#ffffff">
<meta name="description" content="<?php print $info['description']->value; ?>">
<meta name="keywords" content="<?php print $info['keywords']->value; ?>">
<meta name="author" content="<?php print $info['author']->value; ?>">
<meta name="date.created"  content="<?php print $info['created']->value; ?>">
<meta name="date.available"  content="<?php print $info['available']->value; ?>">
<meta name="date.updated"  content="<?php print $info['updated']->value; ?>">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="3 days">
<meta property="og:title" content="<?php print $info['title']->value; ?>">
<meta property="og:site_name" content="<?php print $info['name']->value; ?>">
<meta property="og:url" content="<?php isset($info['url']->value) ? print $info['url']->value : print _BASE_PATH; ?>">
<meta property="og:description" content="<?php print $info['description']->value; ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="<?php echo $info['language']->value; ?>" />
<meta property="og:image" content="<?php !isset($info['image']->value) ?: print $info['image']->value; ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php print $info['title']->value; ?>">
<meta name="twitter:description" content="<?php print $info['description']->value; ?>">
<meta name="twitter:image" content="<?php !isset($info['image']->value) ?: print $info['image']->value; ?>">

<link rel="shortcut icon" type="image/x-icon" href="<?php print _BASE_PATH . _MEDIA_PATH; ?>favicon/favicon.ico">
<link rel="shortcut icon" type="image/gif" href="<?php print _BASE_PATH . _MEDIA_PATH; ?>favicon/favicon.gif">
<link rel="shortcut icon" type="image/png" href="<?php print _BASE_PATH . _MEDIA_PATH; ?>favicon/favicon.png">
<!-- <link rel="icon" type="image/png" href="media/favicon/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="media/favicon/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="media/favicon/favicon-48x48.png" sizes="48x48" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="media/favicon/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="media/favicon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="media/favicon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="media/favicon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon-precomposed" sizes="167x167" href="media/favicon/apple-touch-icon-167x167.png">
<link rel="apple-touch-icon-precomposed" sizes="180x180" href="media/favicon/apple-touch-icon-180x180.png">
<link rel="apple-touch-icon-precomposed" sizes="196x196" href="media/favicon/apple-touch-icon-196x196.png"> -->

<title><?php print $info['title']->value; ?></title>
