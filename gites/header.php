<?php
//$lang = "nl";
//if (isset($_COOKIE['lng']))
//    $lang = $_COOKIE['lng'];
//echo "LANGUAGE=" . $lang;

function tr($key){
//    global $lang;
    $lang = "nl";
    if (isset($_COOKIE['lng']))
        $lang = $_COOKIE['lng'];
    switch($key){
        case 'Prijzen' :
			switch($lang){
				case 'nl':
					return "Prijzen";
					break;
				case 'fr':
					return "Prix";
					break;
				default :
					return 'Rates';
			} 
            break;
        case 'Omgeving' :
			switch ($lang){
				case 'nl':
					return "Omgeving";
					break;
				case 'fr' :
					return "Environs";
            	default :
					return "Surroundings";
			}
            break;
    }
    return "";
}

?>
<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <META NAME="DESCRIPTION" CONTENT="Le petit Viala" />
            <META NAME="KEYWORDS" CONTENT="Le petit Viala" />
            <META NAME='ROBOTS' CONTENT='index, follow' />
            <META NAME='AUTHOR' CONTENT='Le petit Viala' />
            <META NAME='REVISIT-AFTER' CONTENT='7 days' />
            <META NAME='RATING' CONTENT='General' /> 
            <title><?php wp_title(); ?></title>
            <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.cookie.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	    <script>// <![CDATA[
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-65723404-1', 'auto');
ga('send', 'pageview');
// ]]></script>
        </head>
        <body>
            <div id="main">
                <div id="header">
                    <div id="headerpositioning">
                        <img id='swusj' src='<?php bloginfo('stylesheet_directory'); ?>/images/swusj.png' />
                        <img id='logo' src='<?php bloginfo('stylesheet_directory'); ?>/images/logo.png' />
                        <span id="lng">
                                <a class='lng' lng='nl' style='cursor:pointer'><img width='30px' src='<?php bloginfo('stylesheet_directory'); ?>/images/nl.png' /></a>
								<a class='lng' lng='fr' style='cursor:pointer'><img width='27px' src='<?php bloginfo('stylesheet_directory'); ?>/images/fr.png' /></a>
                                <a class='lng' lng='en' style='cursor:pointer'><img width='27px' src='<?php bloginfo('stylesheet_directory'); ?>/images/en.png' /></a>
                        </span>
                        <div id="menu">
                            <div id="menuitems">
                                <ul>
                                    <li href='home' <?php if ($pagename == "home") echo "class='selectedmenu'"; ?>>Home</li>
                                    <li href='gite' <?php if ($pagename == "gite") echo "class='selectedmenu'"; ?>>G&icirc;te</li>
                                    <li href='omgeving' <?php if ($pagename == "omgeving") echo "class='selectedmenu'"; ?>><?php echo tr('Omgeving'); ?></li>
                                    <li href='prijzen' <?php if ($pagename == "prijzen") echo "class='selectedmenu'"; ?>><?php echo tr('Prijzen'); ?></li>
                                    <li href='contact' <?php if ($pagename == "contact") echo "class='selectedmenu'"; ?>>Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="container">