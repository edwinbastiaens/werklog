<?php
include "theme_activation.php";

function setup_theme_admin_menus() {
    $parent_slug = 'themes.php';
    $page_title = 'Gites Element instellingen';
    $menu_title = 'Gites instellingen';
    $capability = 'manage_options';
    $menu_slug =  'front-page-elements'; //menu-identifier
    $function_name =  'gites_menu_page';
    add_submenu_page($parent_slug, $page_title, $menu_title,
                     $capability , $menu_slug , $function_name);
}


function saveSettings(){
    if ( ! isset($_POST['update_settings'])) return;
    if ( $_POST['update_settings'] != 'Y') return;
    $_POST  = array_map( 'stripslashes_deep', $_POST );
    update_option("facebook-link", $_POST["facebook-link"]);
    update_option("twitter-link", $_POST["twitter-link"]);
    update_option("blogger-link", $_POST["blogger-link"]);
    update_option("email", $_POST["email"]);
    update_option("bedankt-voor-reactie", $_POST["bedankt-voor-reactie"]);
    update_option("bedankt-voor-reactie-en", $_POST["bedankt-voor-reactie-en"]);
    update_option("bedankt-voor-reactie-fr", $_POST["bedankt-voor-reactie-fr"]);
    update_option("footer", $_POST["footer"]);
    update_option("contactform-text", $_POST["contactform-text"]);
    update_option("contactform-text-en", $_POST["contactform-text-en"]);
    update_option("contactform-text-fr", $_POST["contactform-text-fr"]);
    echo "<h3 style='color:orange'>Instellingen zijn aangepast!</h3>";
}

function getDefaultValue($parmname){
    $ret = "";
    switch($parmname){
        case 'footer' : $ret = "Le Petit Viala - senem suntist rem 215 - 14528 Essesitam soluptatur"; break;
        case 'facebook-link' : $ret = "http://www.facebook.com";break;
        case 'twitter-link' : $ret = "http://www.twitter.com";break;
        case 'blogger-link' : $ret = "http://www.blogger.com";break;
        case 'bedankt-voor-reactie' : $ret = "Bedankt voor uw reactie.";break;
        case 'bedankt-voor-reactie-en' : $ret = "Thank you for your response.";break;
        case 'bedankt-voor-reactie-fr' : $ret = "Merci pour votre response.";break;
        case 'contactform-text' : $ret = "Om te reserveren gelieve onderstaande contactformulier in te vullen";break;
        case 'contactform-text-en' : $ret = "To make a reservation please fill up the form below.";break;
        case 'contactform-text-fr' : $ret = "Pour faire un reservation svp entre le form.";break;
    }
    if ($ret != "")
        update_option($parmname,$ret);
    return $ret;
}

function getInputRow($parmname,$title,$type='input'){
    $value = get_option($parmname);
    if ($value == "") $value = getDefaultValue($parmname);
    switch($type){
        case 'input':$i = "<input name='".$parmname."' value='".$value."' />";break; 
        case 'textarea':$i = "<textarea rows='5' cols='40' name='".$parmname."'>".$value."</textarea>";break; 
    }
    return '<tr valign="top">
            <th scope="row">
                <label>'.$title.':</label>
            </th>
            <td>
                '.$i.'
            </td>
        </tr>';
}

function gites_menu_page() {
    if (!current_user_can('manage_options')) 
        wp_die('You do not have sufficient permissions to access this page.');
    screen_icon('themes'); 
    echo "<h2>Gites Specifieke aanpassingen</h2>";
    if (isset($_POST["update_settings"]))
        saveSettings();
    $settings = '<form method="POST" action=""><table>';
    $settings .= getInputRow('facebook-link','Facebook link');
    $settings .= getInputRow('twitter-link','Twitter link');
    $settings .= getInputRow('blogger-link','Blogger link');
    $settings .= getInputRow('email','Email address to receive registration mails.');
    $settings .= getInputRow('bedankt-voor-reactie','Antwoord op ingevuld formulier (nl).');
    $settings .= getInputRow('bedankt-voor-reactie-en','Antwoord op ingevuld formulier (en).');
    $settings .= getInputRow('bedankt-voor-reactie-fr','Antwoord op ingevuld formulier (fr).');
    $settings .= getInputRow('footer','Footer');
    $settings .= getInputRow('contactform-text','Text boven contact formulier (nl)');
    $settings .= getInputRow('contactform-text-en','Text boven contact formulier (en)');
    $settings .= getInputRow('contactform-text-fr','Text boven contact formulier (fr)');
    $settings .= '</table>
                <input type="hidden" name="update_settings" value="Y" />
                    <!--<a href="#" id="add-featured-post">Aapassen</a> -->
                    <input type="submit" value="Aanpassen" />
                </form>';
    echo "<div class='wrap'>" . $settings . "</div>";
}
//
// This tells WordPress to call the function named "setup_theme_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_theme_admin_menus");

//require_once( 'wptuts-options/wptuts-options.php' );

function process_contact_form(){
    if (isset($_POST['contactformsent'])){
        $eml = get_option('email');
        if ($eml != ""){
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            //$headers .= "From: Gites <info@gites.be>\r\n";
            $msg = "";
            foreach ($_POST as $k => $v)
                $msg .= $k . ": " . $v . "<br/>";
            mail($eml,'bericht van gites website',$msg,$headers);
        }
    }
}

function get_current_lang(){
    $curlang = "nl";
    if (isset($_COOKIE['lng']))
        $curlang = $_COOKIE['lng'];
    return $curlang;
}

function getLang($arr,$default = ""){
    $lng = get_current_lang();
    if ( isset($arr[$lng]))
        return $arr[$lng];
    else
        return $default;
}

function get_contact_form(){
    if (isset($_POST['contactformsent'])){
        switch(get_current_lang()){
            case 'en':
                return get_option('bedankt-voor-reactie-en');
                break;
            case 'fr':
                return get_option('bedankt-voor-reactie-fr');
                break;
            default:
                return get_option('bedankt-voor-reactie');
        }
    }
    else {
        switch(get_current_lang()){
            case 'en':
                $frmtxt = get_option('contactform-text-en');
                break;
            case 'fr':
                $frmtxt = get_option('contactform-text-fr');
                break;
            default :
                $frmtxt = get_option('contactform-text');
        } 
          
        return "<div>
        <form method='POST'>
            ".$frmtxt."<br/>
            <input type='hidden' name='contactformsent' value='1' />
            <input type='input' name='naam' required placeholder='".getLang(["nl"=>"Naam","fr"=>"Nom", "en"=>"Name"])."' /><br/>
            <input type='eml' name='email' required placeholder='E-mail' /><br/>
            <textarea name='txt' id='text'  placeholder='".getLang(["nl"=>"Opmerking","fr"=>"Remarque", "en"=>"Remark"])."'></textarea>
            <input type='submit' value='".getLang(["en"=>"Send","fr"=>"Envoyer"],"Verzenden")."' /><br/>
        </form></div>";
    }
}

function get_lang($atts,$content = null){
    $curlang = get_current_lang();
    $lng = "nl";
    
    extract(shortcode_atts(array(
      'lng' => 'nl',
    ), $atts));
    
    if ($lng == $curlang)
        return $content;
    else
        return "";
}

function get_geomap($atts){
    $latlon = $atts['latlon'];
    $coords = explode(";",$latlon);
    return "<div class='geomapcentral' id='map-canvas' lon='".$coords[1]."' lat='".$coords[0]."' ></div>";
}

function register_shortcodes(){
    add_shortcode( 'contactform', 'get_contact_form' );
    add_shortcode( 'lang', 'get_lang' );
    add_shortcode( 'geomap', 'get_geomap' );
}

add_action( 'init', 'register_shortcodes');

process_contact_form();
?>