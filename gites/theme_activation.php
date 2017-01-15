<?php
//automatisch pages creeren als die nog  niet bestaan
$existingpages = null;
function pageExists($pagename){
    global $existingpages;    
    foreach ($existingpages as $page)
        if ($page->post_name == $pagename) return $page;
    return false;
}

function getContent4Page($pagename){
    $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus euismod vulputate metus non accumsan. Maecenas sed eros ligula. Curabitur sagittis enim vel diam lobortis iaculis. Pellentesque eu ultrices mauris, a aliquet mi. Nulla facilisi. Maecenas elit ante, sagittis sed egestas a, suscipit sodales tortor. Ut ut tempor magna. Phasellus rutrum convallis est eget rhoncus. Etiam mattis posuere ipsum, porttitor pretium purus tristique ac. In rhoncus sem ligula, vitae convallis sapien commodo sit amet. Donec ornare porttitor blandit. Morbi sit amet justo risus.<br/>
Donec nec congue eros. Mauris sapien eros, ullamcorper ut dolor eget, efficitur laoreet mi. Aliquam sed dolor a enim commodo iaculis. Sed orci leo, tempus ut sodales ac, ullamcorper id felis. Nulla lacinia eleifend enim ut dictum. Quisque scelerisque vel est sed sagittis. Etiam a leo cursus, viverra metus ut, consectetur dui. Sed aliquam quis turpis et varius. Curabitur hendrerit gravida placerat. Sed non dignissim arcu. Nam gravida bibendum eleifend. In enim velit, efficitur eu placerat quis, scelerisque vulputate mi. Vivamus mattis condimentum justo nec tempus. Duis rutrum orci ac odio lacinia lacinia.
Fusce eget eros lorem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam finibus semper nunc at pretium. In vel ornare ligula. Maecenas et condimentum neque, in faucibus massa. Proin non tempor massa, vitae placerat sapien. Proin sem nibh, feugiat at ornare ut, iaculis ac ex. Vestibulum ut cursus justo, sed finibus arcu. Nullam et eros turpis. Proin pellentesque lectus et commodo tempus.
In eget vestibulum nunc, vel rutrum felis. Donec quis posuere tortor. Nullam fringilla dui quis ligula facilisis, eget tincidunt libero tempus. Nam malesuada erat non volutpat vulputate. Etiam lobortis facilisis semper. Vivamus at lorem vitae massa egestas luctus quis quis massa. Aliquam sit amet accumsan odio, eget commodo ipsum. Suspendisse potenti.<br/>
Aliquam imperdiet libero in tempor lobortis. Etiam ut velit nec enim eleifend maximus quis non dui. Morbi hendrerit id eros sed cursus. Aenean scelerisque magna lobortis, tincidunt dui ut, tincidunt justo. Sed finibus ultricies sapien id convallis. Nulla rhoncus efficitur ipsum. Phasellus sollicitudin ornare risus in pharetra. Praesent vulputate turpis tellus, ac ornare libero lobortis id. Integer facilisis luctus lacus at tincidunt. Mauris iaculis nibh massa, vitae egestas tortor semper ac. Suspendisse iaculis accumsan purus, vitae interdum ex auctor at. Suspendisse vel ultricies mauris, id aliquet est.";
    $ret = $lorem;
    switch($pagename){
        case 'home':$ret = "Hallo" . $lorem;break;
        case 'gite':break;
        case 'omgeving':break;
        case 'prijzen':break;
        case 'contact':break;
    }
    return $lorem;
}

function check2createPage($pagename){
    global $user_ID;
    if (!pageExists($pagename)){
        $page['post_type']    = 'page';
        $page['post_content'] = getContent4Page($pagename);
        $page['post_parent']  = 0;
        $page['post_author']  = $user_ID;
        $page['post_status']  = 'publish';
        $page['post_title']   = $pagename;
        $page = apply_filters('yourplugin_add_new_page', $page, 'teams');
        $pageid = wp_insert_post ($page);    
    }
}
//
add_action('after_switch_theme', 'mfw_theme_activation'); // 'after_setup_theme'

function mfw_theme_activation() {
    global $existingpages;
    $existingpages = get_pages();
    check2createPage("home");
    check2createPage("gite");
    check2createPage("omgeving");
    check2createPage("prijzen");
    check2createPage("contact");
}

?>