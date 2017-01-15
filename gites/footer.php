                    <div id="footer">
                        <div id="social">
                            <a href='<?php echo get_option('facebook-link'); ?>' target='_blank'><img src='<?php bloginfo('stylesheet_directory'); ?>/images/fb.png'/></a>
                            <a href='<?php echo get_option('twitter-link'); ?>' target='_blank'><img src='<?php bloginfo('stylesheet_directory'); ?>/images/tw.png'/></a>
                            <a href='<?php echo get_option('blogger-link'); ?>' target='_blank'><img src='<?php bloginfo('stylesheet_directory'); ?>/images/bl.png'/></a>
                        </div>
                        <div id="footerbalk">
                            <?php echo get_option('footer'); ?>
                            <br/><a style='text-decoration:none;color:#884C28;font-size:0.8em;' href='http://www.missviss.com' target='_blank'>design: www.missviss.com</a> <span style='color:#884C28'>-</span>
                            <a style='text-decoration:none;color:#884C28;font-size:0.8em;' href='http://www.tolima.be' target='_blank'>development: www.tolima.be</a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function deleteAllCookies() {
                    var cookies = document.cookie.split(";");
 //               alert("alle cookies:" + cookies);
                    for (var i = 0; i < cookies.length; i++) {
                        var cookie = cookies[i];
                        var eqPos = cookie.indexOf("=");
                        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                    }
                }

                function eraseCookieFromAllPaths(name) {
                    // This function will attempt to remove a cookie from all paths.
                    var pathBits = location.pathname.split('/');
                    
                    var pathCurrent = ' path=';
                
                    // do a simple pathless delete first.
                    document.cookie = name + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT;';
                
                    for (var i = 0; i < pathBits.length; i++) {
                        pathCurrent += ((pathCurrent.substr(-1) != '/') ? '/' : '') + pathBits[i];
                        document.cookie = name + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT;' + pathCurrent + ';';
                    }
                }
                function setCookie(cname, cvalue, exdays) {
                    eraseCookieFromAllPaths(cname);
                    var d = new Date();
                    d.setTime(d.getTime() + (exdays*24*60*60*1000));
                    var expires = "expires="+d.toGMTString();
                    var cookieval = cname + "=" + cvalue + "; " + expires + "; path=/; domain=.lepetitviala.com; ";
                    document.cookie = cookieval;
   //                 alert("nieuwe cookie:" + cookieval);
                    
                }
                function getCookie(cname) {
                    var name = cname + "=";
                    var ca = document.cookie.split(';');
                    for(var i=0; i<ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0)==' ') c = c.substring(1);
                        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
                    }
                    return "";
                }
     //           alert("lang:" + document.cookie);
                jQuery('#menuitems ul li').click(function(){
                    var href = jQuery(this).attr("href");
                    if (href == undefined) return;
                    window.open(href,"_self");
                });
                jQuery('.lng').click(function(){
                    var lng = jQuery(this).attr("lng");
                    //setCookie('lng',lng,500);
                    $.cookie('lng',lng,{path:'/',domain:''});
                    window.open(document.location.href,"_self");
                });

                /* initialize the googlemap */
                var mygeomap = null;
                function schietMarkerIn(lat,lon,name){
                    // Creating a marker and positioning it on the map
                  var marker = new google.maps.Marker({    
                    position: new google.maps.LatLng(lat,lon),    
                    map: mygeomap,
                    icon: '<?php bloginfo('stylesheet_directory'); ?>/images/map_point.png',
                    title:name,
                    imgsrc:'',
                    url:'',
                  });  
                
                }
                
                jQuery( function(){
                    var mc = document.getElementById("map-canvas");
                    var mcj = jQuery("#map-canvas");
                    var lon = mcj.attr('lon');
                    var lat = mcj.attr('lat');
                    var ttl = mcj.attr('title');
                    var latlng = new google.maps.LatLng(lat, lon);  
                    var myOptions = {  
                        zoom: 9,  
                        center: latlng,  
                        mapTypeId: google.maps.MapTypeId.ROADMAP  
                    };
                    mygeomap = new google.maps.Map(mc, myOptions);
                    schietMarkerIn(lat, lon, ttl);
                });
            </script>
            <?php  wp_footer(); ?>
        </body>
    </html>