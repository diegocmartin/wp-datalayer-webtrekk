<?php
/*
  Plugin Name: WP datalayer for Webtrekk
  Plugin URI: https://webtrekk.com/
  Description: WP datalayer for Webtrekk creates a datalayaer...
  Version: 1.0
  Author: Diego C Martin
  Author URI: https://www.diegocmartin.com
  License: GPLv2+
  Text Domain: wp-datalayer-for-webtrekk
*/

class WP_Datalayer_Webtrekk{
    // Constructor
      function __construct() {
          add_action( 'admin_menu', array( $this, 'wt_add_menu' ));
          register_activation_hook( __FILE__, array( $this, 'wt_install' ) );
          register_deactivation_hook( __FILE__, array( $this, 'wt_uninstall' ) );
          //Encueue styles with the function wt_styles at the bottom
          add_action( 'admin_enqueue_scripts', array( $this, 'wt_styles') );
          //adding the function to add the pixel to the head
          add_action( 'wp_head', 'add_wt_pixel', '111111111111111' );
          //adding the function to add the datalayer to the footer
          add_action( 'wp_footer', 'add_wtdl_to_footer' );
      }
  
      /*
        * Actions perform at loading of admin menu
        */
      function wt_add_menu() {
          add_menu_page( 'WP Datalayer Webtrekk', 'Webtrekk', 'administrator', 'webtrekk-dashboard', array(
                            __CLASS__,
                           'wt_page_file_path'
                          ), plugins_url('images/wt.png', __FILE__));
  
          add_submenu_page( 'webtrekk-dashboard', 'WP Datalayer Webtrekk' . ' Dashboard', ' Dashboard', 'manage_options', 'webtrekk-dashboard', array(
                                __CLASS__,
                               'wt_page_file_path'
                              ));
  
          add_submenu_page( 'webtrekk-dashboard', 'WP Datalayer Webtrekk' . ' Settings', '<b style="color:#6F8B2D">Settings</b>', 'manage_options', 'webtrekk-settings', array(
                                __CLASS__,
                               'wt_page_file_path'
                              ));
      }
  
      /*
       * Actions perform on loading of menu pages
       */
      function wt_page_file_path() {
  
  
  
      }
  
      /*
       * Actions perform on activation of plugin
       */
      function wt_install() {
  
  
  
      }
  
      /*
       * Actions perform on de-activation of plugin
       */
      function wt_uninstall() {
  
  
  
      }

        /**
         * Styling: loading stylesheets for the plugin.
         */
        public function wt_styles( $page ) {

            wp_enqueue_style( 'wp-datalayer-webtrekk-style', plugins_url('css/wp-datalayer-webtrekk-style.css', __FILE__));
        }

        /**
         * Adding pixel code.
         */
        public function add_wt_pixel($tiId) {
            //Páginas no admin
            if(!is_admin() && !is_network_admin()){
            ?>
                <script>
                    window._tiConfig = window._tiConfig || {
                        tiDomain: 'responder.wt-safetag.com',
                        tiId: '<?php echo $tiId; ?>',
                        option: {}
                    };
                    (function(a,d,c,f){a.wts=a.wts||[];var g=function(b){var a="";b.customDomain&&b.customPath?a=b.customDomain+"/"+b.customPath:b.tiDomain&&b.tiId&&(a=b.tiDomain+"/resp/api/get/"+b.tiId+"?url="+encodeURIComponent("https://"+d.location.host+"/")+"&v=5");if(b.option)for(var c in b.option)a+="&"+c+"="+encodeURIComponent(b.option[c]);return a};if(-1===d.cookie.indexOf("wt_r=1")){var e=d.getElementsByTagName(c)[0];c=d.createElement(c);c.async=!0;c.onload=function(){if("undefined"!==typeof a.wt_r&&!isNaN(a.wt_r)){var b=
                    new Date,c=b.getTime()+1E3*parseInt(a.wt_r);b.setTime(c);d.cookie="wt_r=1;path=/;expires="+b.toUTCString()}};c.onerror=function(){"undefined"!==typeof a.wt_mcp_hide&&"function"===typeof a.wt_mcp_hide.show&&(a.wt_mcp_hide.show(),a.wt_mcp_hide.show=function(){})};c.src="//"+g(f);e.parentNode.insertBefore(c,e)}})(window,document,"script",_tiConfig);
                </script>
            <?php
            }
        }

        public function add_wtdl_to_footer(){
            if(!is_admin() && !is_network_admin()){
                if (is_singular()) {
                    $PagePostType = get_post_type();
                    $PageTemplate = "single";//Aquí mirar si puedo generar tipos de página
                    $_post_cats = get_the_category();
                    if ($_post_cats) {
                        foreach ($_post_cats as $_one_cat) {
                            $PageCategory = $_one_cat->slug;
                        }
                    }
                    $_post_tags = get_the_tags();
                    if ($_post_tags) {
                        foreach ($_post_tags as $_one_tag) {
                            $PageTags = $_one_tag->slug;
                        }
                    }
                    $postuser = get_userdata($GLOBALS["post"]->post_author);
                    if (false !== $postuser) {
                        $PagePostAuthorID = $postuser->ID;
                        $PagePostAuthor = $postuser->display_name;
                    }
            
                    $PagePostDateYear = get_the_date("Y");
                    $PagePostDateMonth = get_the_date("m");
                    $PagePostDateDay = get_the_date("d");
                } //isSingluar
                $WPUserType = wp_get_current_user()->roles[0];
                ?>
                    <script type="text/javascript">
                    /*DATALAYER*/
                    //función para buscar un término dentro de una url. Devuelve el término o -1 si no lo encuentra.
                    function extraeDeURL(url,txt){
                        const index = url.indexOf(txt);
                        if (index>=0){
                            return url.substring(index+txt.length,url.length);
                        }
                        else return index;
                    }
                    //Si no es producto o no es la confirmación, no envío datos, esto se hará mediante el plugin de ecommerce
                    //if (("<_?php echo $PagePostType; ?>"!=="product") || (window.location.href.indexOf("order-received")!=-1)){
                        //Se usa el objeto wtdl
                        if (typeof wtdl == "undefined")  var wtdl={};
                        //Obtener URL Completa cp 01
                        wtdl.urlCompleta=window.location.href;
                        // Autor cp01
                        wtdl.cp01 = "<?php echo $PagePostAuthor; ?>";
                        wtdl.cp03 = "<?php echo $PagePostDateYear; ?>";
                        wtdl.cp04 = "<?php echo $PagePostDateMonth; ?>";
                        wtdl.cp05 = "<?php echo $PagePostDateDay; ?>";

                        ////Nombre Página
                        //Eliminar parámetros de una URL
                        //identificar carácter ?
                        const index = wtdl.urlCompleta.indexOf("?");
                        if (index >= 0) { 
                            wtdl.pagina = wtdl.urlCompleta.substring(0,index);
                        }
                        else{
                            wtdl.pagina = wtdl.urlCompleta;
                        }
                        
                        //Obtener término de búsqueda interna
                        const searchTerm = extraeDeURL(wtdl.urlCompleta,"?s=");
                        if (searchTerm!==-1) wtdl.is = searchTerm;
                        
                        //Obtener login Status y user ID
                        const login="<?php if (is_user_logged_in()) {echo "logged";} ?>"
                        if (login=="logged") {
                            wtdl.loginStatus="logged";
                            wtdl.userId = "<?php echo get_current_user_id(); ?>";
                            wtdl.userType = "<?php echo $WPUserType; ?>";
                        }
                        else {wtdl.loginStatus="anonymous";}
                        
                        //Obtener categoría blog nivel 1?? * Ojo! la variable PHP devuelve array.
                        if ("<?php echo $PageCategory; ?>"!=="") {
                            wtdl.cg2 = "<?php echo $PageCategory; ?>";
                            //cp776 - Page Title Ojo! * sólo devuelve una.
                            wtdl.cp776 = document.getElementsByTagName("h1")[0].innerText;
                            //775 etiquetas
                            wtdl.cp775 = "<?php echo $PageTags; ?>";
                        }
                        //cg2 como tipo de página
                        if ("<?php echo $PagePostType; ?>"!=="") wtdl.cg1 = "<?php echo $PagePostType; ?>";
                    //}
                    </script>
                <?php
            } //!isAdmin
        }
    }
    new WP_Datalayer_Webtrekk();
?>
