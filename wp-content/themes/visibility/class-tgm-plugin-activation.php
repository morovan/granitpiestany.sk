<?php

if( ! class_exists( 'TGM_Plugin_Activation' )){
  class TGM_Plugin_Activation {
    public static $instance;
      public $plugins = array();
        public $menu = 'tgmpa-install-plugins';
        public $default_path = '';
        public $has_notices = true;
        public $dismissable = true;
        public $dismiss_msg = '';
        public $is_automatic = false;
        public $message = '';
        public $strings = array();
        public $wp_version;
        public function __construct(){
          self::$instance = $this;

          $this->strings = array(
            'page_title'                     => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                     => __( 'Install Plugins', 'tgmpa' ),
            'installing'                     => __( 'Installing Plugin: %s', 'tgmpa' ),
            'oops'                           => __( 'Something went wrong.', 'tgmpa' ),
            'notice_can_install_required'    => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
            'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
            'notice_cannot_install'          => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
            'notice_can_activate_required'   => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
            'notice_can_activate_recommended'=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
            'notice_cannot_activate'         => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
            'notice_ask_to_update'           => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
            'notice_cannot_update'           => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
            'install_link'                   => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                  => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                         => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'dashboard'                      => __( 'Return to the dashboard', 'tgmpa' ),
            'plugin_activated'               => __( 'Plugin activated successfully.', 'tgmpa' ),
            'activated_successfully'         => __( 'The following plugin was activated successfully:', 'tgmpa' ),
            'complete'                       => __( 'All plugins installed and activated successfully. %1$s', 'tgmpa' ),
            'dismiss'                        => __( 'Dismiss this notice', 'tgmpa' ),
          );
            global $wp_version;
            $this->wp_version = $wp_version;
            do_action_ref_array( 'tgmpa_init', array( $this ) );
            add_action( 'init', array( $this, 'init' ) );
        }
        public function init(){
          do_action( 'tgmpa_register' );

          if( $this->plugins ){
            $sorted = array();

            foreach ( $this->plugins as $plugin ) {
              $sorted[] = $plugin['name'];
            }
            array_multisort( $sorted, SORT_ASC, $this->plugins );

            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'admin_head', array( $this, 'dismiss' ) );
            add_filter( 'install_plugin_complete_actions', array( $this, 'actions' ) );
            add_action( 'switch_theme', array( $this, 'flush_plugins_cache' ) );

            if( $this->is_tgmpa_page()){
              remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
              remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
              add_action( 'wp_head', 'wp_admin_bar_render', 1000 );
              add_action( 'admin_head', 'wp_admin_bar_render', 1000 );
            }

            if( $this->has_notices ){
              add_action( 'admin_notices', array( $this, 'notices' ) );
              add_action( 'admin_init', array( $this, 'admin_init' ), 1 );
              add_action( 'admin_enqueue_scripts', array( $this, 'thickbox' ) );
              add_action( 'switch_theme', array( $this, 'update_dismiss' ) );
            }

            foreach( $this->plugins as $plugin ){
              if( isset( $plugin['force_activation'] ) && true === $plugin['force_activation'] ){
                add_action( 'admin_init', array( $this, 'force_activation' ) );
                break;
              }
            }
            foreach ( $this->plugins as $plugin ){
              if( isset( $plugin['force_deactivation'] ) && true === $plugin['force_deactivation'] ) {
                add_action( 'switch_theme', array( $this, 'force_deactivation' ) );
                break;
              }
            }
          }
        }
        public function admin_init(){
          if( ! $this->is_tgmpa_page()){
            return;
          }

          if ( isset( $_REQUEST['tab'] ) && 'plugin-information' == $_REQUEST['tab'] ) {
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            wp_enqueue_style( 'plugin-install' );

            global $tab, $body_id;
            $body_id = $tab = 'plugin-information';

            install_plugin_information();

            exit;
          }
        }
        public function thickbox(){
          if( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', true )){
            add_thickbox();
          }
        }
        public function admin_menu(){
          if( ! current_user_can( 'install_plugins' ) ){
            return;
          }
          $this->populate_file_path();
          foreach ( $this->plugins as $plugin ) {
            if( ! is_plugin_active( $plugin['file_path'] ) ){
              add_theme_page(
                $this->strings['page_title'],
                $this->strings['menu_title'],
                'edit_theme_options',
                $this->menu,
                array( $this, 'install_plugins_page' )
              );
             break;
            }
          }
        }
        public function install_plugins_page(){
          $plugin_table = new TGMPA_List_Table;
          if( isset( $_POST['action'] ) && 'tgmpa-bulk-install' == $_POST['action'] && $plugin_table->process_bulk_actions() || $this->do_plugin_install() ){
            return;
          }
            ?>
            <div class="tgmpa wrap">
              <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
              <?php $plugin_table->prepare_items(); ?>
                <?php if ( isset( $this->message ) ){
                  echo wp_kses_post( $this->message );
                } ?>

                <form id="tgmpa-plugins" action="" method="post">
                  <input type="hidden" name="tgmpa-page" value="<?php echo $this->menu; ?>" />
                  <?php $plugin_table->display(); ?>
                </form>
            </div>
            <?php
        }
        protected function do_plugin_install(){
          $plugin = array();
            if( isset( $_GET['plugin'] ) && ( isset( $_GET['tgmpa-install'] ) && 'install-plugin' == $_GET['tgmpa-install'] ) ){
              check_admin_referer( 'tgmpa-install' );
                $plugin['name']   = $_GET['plugin_name'];
                $plugin['slug']   = $_GET['plugin'];
                $plugin['source'] = $_GET['plugin_source'];

                $url = wp_nonce_url(
                  add_query_arg(
                    array(
                      'page'          => urlencode( $this->menu ),
                      'plugin'        => urlencode( $plugin['slug'] ),
                      'plugin_name'   => urlencode( $plugin['name'] ),
                      'plugin_source' => urlencode( $plugin['source'] ),
                      'tgmpa-install' => 'install-plugin',
                    ),
                    network_admin_url( 'themes.php' )
                  ),
                  'tgmpa-install'
                );
                $method = '';
                $fields = array( 'tgmpa-install' );

                if( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ){
                    return true;
                }

                if( ! WP_Filesystem( $creds ) ){
                  request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields ); // Setup WP_Filesystem.
                  return true;
                }

                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

                if( isset( $plugin['source'] ) && 'repo' == $plugin['source'] ){
                  $api = plugins_api( 'plugin_information', array( 'slug' => $plugin['slug'], 'fields' => array( 'sections' => false ) ) );

                  if( is_wp_error( $api ) ){
                    wp_die( $this->strings['oops'] . var_dump( $api ) );
                  }

                  if( isset( $api->download_link ) ){
                    $plugin['source'] = $api->download_link;
                  }
                }
                $type = preg_match( '|^http(s)?://|', $plugin['source'] ) ? 'web' : 'upload';

                $title = sprintf( $this->strings['installing'], $plugin['name'] );
                $url   = add_query_arg( array( 'action' => 'install-plugin', 'plugin' => urlencode( $plugin['slug'] ) ), 'update.php' );
                if( isset( $_GET['from'] ) ){
                  $url .= add_query_arg( 'from', urlencode( stripslashes( $_GET['from'] ) ), $url );
                }

                $url   = esc_url_raw( $url );

                $nonce = 'install-plugin_' . $plugin['slug'];

                $source = ( 'upload' == $type ) ? $this->default_path . $plugin['source'] : $plugin['source'];

                $upgrader = new Plugin_Upgrader( $skin = new Plugin_Installer_Skin( compact( 'type', 'title', 'url', 'nonce', 'plugin', 'api' ) ) );

                $upgrader->install( $source );

                wp_cache_flush();

                if( $this->is_automatic ){
                  $plugin_activate = $upgrader->plugin_info();
                  $activate        = activate_plugin( $plugin_activate );
                  $this->populate_file_path();

                  if( is_wp_error( $activate ) ){
                    echo '<div id="message" class="error"><p>' . $activate->get_error_message() . '</p></div>';
                    echo '<p><a href="' . esc_url( add_query_arg( 'page', urlencode( $this->menu ), network_admin_url( 'themes.php' ) ) ) . '" title="' . esc_attr( $this->strings['return'] ) . '" target="_parent">' . $this->strings['return'] . '</a></p>';
                    return true;
                  }
                  else{
                    echo '<p>' . $this->strings['plugin_activated'] . '</p>';
                  }
                }

                $complete = array();
                foreach( $this->plugins as $plugin ){
                  if( ! is_plugin_active( $plugin['file_path'] ) ){
                    echo '<p><a href="' . esc_url( add_query_arg( 'page', urlencode( $this->menu ), network_admin_url( 'themes.php' ) ) ) . '" title="' . esc_attr( $this->strings['return'] ) . '" target="_parent">' . $this->strings['return'] . '</a></p>';
                    $complete[] = $plugin;
                    break;
                  }
                  else{
                    $complete[] = '';
                  }
                }
                $complete = array_filter( $complete );

                if( empty( $complete ) ){
                  echo '<p>' .  sprintf( $this->strings['complete'], '<a href="' . esc_url( network_admin_url() ) . '" title="' . esc_attr__( 'Return to the Dashboard', 'tgmpa' ) . '">' . __( 'Return to the Dashboard', 'tgmpa' ) . '</a>' ) . '</p>';
                  echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';
                }
                return true;
        }
        elseif ( isset( $_GET['plugin'] ) && ( isset( $_GET['tgmpa-activate'] ) && 'activate-plugin' == $_GET['tgmpa-activate'] ) ) {
          check_admin_referer( 'tgmpa-activate', 'tgmpa-activate-nonce' );

          $plugin['name']   = $_GET['plugin_name'];
          $plugin['slug']   = $_GET['plugin'];
          $plugin['source'] = $_GET['plugin_source'];

          $plugin_data = get_plugins( '/' . $plugin['slug'] );
          $plugin_file = array_keys( $plugin_data );
          $plugin_to_activate = $plugin['slug'] . '/' . $plugin_file[0];
          $activate = activate_plugin( $plugin_to_activate );

          if ( is_wp_error( $activate ) ) {
            echo '<div id="message" class="error"><p>' . $activate->get_error_message() . '</p></div>';
            echo '<p><a href="' . esc_url( add_query_arg( 'page', urlencode( $this->menu ), network_admin_url( 'themes.php' ) ) ) . '" title="' . esc_attr( $this->strings['return'] ) . '" target="_parent">' . $this->strings['return'] . '</a></p>';
            return true;
          }
          else{
            if( ! isset( $_POST['action'] ) ){
              $msg = $this->strings['activated_successfully'] . ' <strong>' . $plugin['name'] . '.</strong>';
              echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';
            }
          }
        }
        return false;
        }
        public function notices(){
          global $current_screen;
          if( $this->is_tgmpa_page() ){
              return;
          }
          if( get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', true )){
              return;
          }
          $installed_plugins = get_plugins();
          $this->populate_file_path();

          $message             = array();
          $install_link        = false;
          $install_link_count  = 0;
          $activate_link       = false;
          $activate_link_count = 0;

          foreach ( $this->plugins as $plugin ){
            if( is_plugin_active( $plugin['file_path'] )){
              if( isset( $plugin['version'] )){
                if( isset( $installed_plugins[$plugin['file_path']]['Version'] )){
                  if( version_compare( $installed_plugins[$plugin['file_path']]['Version'], $plugin['version'], '<' )){
                    if( current_user_can( 'install_plugins' )){
                      $message['notice_ask_to_update'][] = $plugin['name'];
                    }else{
                      $message['notice_cannot_update'][] = $plugin['name'];
                    }
                  }
                }
                else{
                  continue;
                }
              }
              else{
                continue;
              }
            }
            if( ! isset( $installed_plugins[$plugin['file_path']] )){
              $install_link = true;
              $install_link_count++;
              if( current_user_can( 'install_plugins' )){
                if( $plugin['required'] ){
                  $message['notice_can_install_required'][] = $plugin['name'];
                }
                else{
                  $message['notice_can_install_recommended'][] = $plugin['name'];
                }
              }
              else{
                $message['notice_cannot_install'][] = $plugin['name'];
              }
            }
            elseif ( is_plugin_inactive( $plugin['file_path'] ) ){
              $activate_link = true;
              $activate_link_count++;
              if( current_user_can( 'activate_plugins' ) ){
                if( isset( $plugin['required'] ) && $plugin['required'] ){
                  $message['notice_can_activate_required'][] = $plugin['name'];
                }
                else{
                  $message['notice_can_activate_recommended'][] = $plugin['name'];
                }
              }
              else{
                $message['notice_cannot_activate'][] = $plugin['name'];
              }
            }
          }
          if( ! empty( $message ) ){
            krsort( $message );
            $rendered = '';
            if( ! $this->dismissable && ! empty( $this->dismiss_msg ) ){
              $rendered .= '<p><strong>' . wp_kses_post( $this->dismiss_msg ) . '</strong></p>';
            }
            foreach( $message as $type => $plugin_groups ){
              $linked_plugin_groups = array();
              $count = count( $plugin_groups );

              foreach( $plugin_groups as $plugin_group_single_name ){
                $external_url = $this->_get_plugin_data_from_name( $plugin_group_single_name, 'external_url' );
                $source       = $this->_get_plugin_data_from_name( $plugin_group_single_name, 'source' );

                if( $external_url && preg_match( '|^http(s)?://|', $external_url ) ){
                  $linked_plugin_groups[] = '<a href="' . esc_url( $external_url ) . '" title="' . esc_attr( $plugin_group_single_name ) . '" target="_blank">' . $plugin_group_single_name . '</a>';
                }
                elseif( ! $source || preg_match( '|^http://wordpress.org/extend/plugins/|', $source )){
                  $url = add_query_arg(
                    array(
                      'tab'       => 'plugin-information',
                      'plugin'    => urlencode( $this->_get_plugin_data_from_name( $plugin_group_single_name ) ),
                      'TB_iframe' => 'true',
                      'width'     => '640',
                      'height'    => '500',
                    ),
                    network_admin_url( 'plugin-install.php' )
                  );
                  $linked_plugin_groups[] = '<a href="' . esc_url( $url ) . '" class="thickbox" title="' . esc_attr( $plugin_group_single_name ) . '">' . $plugin_group_single_name . '</a>';
                }
                else{
                  $linked_plugin_groups[] = $plugin_group_single_name; // No hyperlink.
                }

                if( isset( $linked_plugin_groups ) && (array) $linked_plugin_groups ){
                    $plugin_groups = $linked_plugin_groups;
                }
              }

                $last_plugin = array_pop( $plugin_groups ); // Pop off last name to prep for readability.
                $imploded    = empty( $plugin_groups ) ? '<em>' . $last_plugin . '</em>' : '<em>' . ( implode( ', ', $plugin_groups ) . '</em> and <em>' . $last_plugin . '</em>' );

                $rendered .= '<p>' . sprintf( translate_nooped_plural( $this->strings[$type], $count, 'tgmpa' ), $imploded, $count ) . '</p>';
            }

            // Setup variables to determine if action links are needed.
            $show_install_link  = $install_link ? '<a href="' . esc_url( add_query_arg( 'page', urlencode( $this->menu ), network_admin_url( 'themes.php' ) ) ) . '">' . translate_nooped_plural( $this->strings['install_link'], $install_link_count, 'tgmpa' ) . '</a>' : '';
            $show_activate_link = $activate_link ? '<a href="' . esc_url( add_query_arg( 'page', urlencode( $this->menu ), network_admin_url( 'themes.php' ) ) ) . '">' . translate_nooped_plural( $this->strings['activate_link'], $activate_link_count, 'tgmpa' ) . '</a>'  : '';
              // Define all of the action links.
            $action_links = apply_filters(
              'tgmpa_notice_action_links',
              array(
                'install'  => ( current_user_can( 'install_plugins' ) )  ? $show_install_link  : '',
                'activate' => ( current_user_can( 'activate_plugins' ) ) ? $show_activate_link : '',
                'dismiss'  => $this->dismissable ? '<a class="dismiss-notice" href="' . esc_url( add_query_arg( 'tgmpa-dismiss', 'dismiss_admin_notices' ) ) . '" target="_parent">' . $this->strings['dismiss'] . '</a>' : '',
              )
            );
            $action_links = array_filter( $action_links ); // Remove any empty array items.
            if( $action_links ){
              $rendered .= '<p>' . implode( ' | ', $action_links ) . '</p>';
            }
            // Register the nag messages and prepare them to be processed.
            $nag_class = version_compare( $this->wp_version, '3.8', '<' ) ? 'updated' : 'update-nag';
            if( ! empty( $this->strings['nag_type'] ) ){
              add_settings_error( 'tgmpa', 'tgmpa', $rendered, sanitize_html_class( strtolower( $this->strings['nag_type'] ) ) );
            }else{
              add_settings_error( 'tgmpa', 'tgmpa', $rendered, $nag_class );
            }
          }
          // Admin options pages already output settings_errors, so this is to avoid duplication.
          if( 'options-general' !== $current_screen->parent_base ){
            settings_errors( 'tgmpa' );
          }
        }
        public function dismiss() {
          if ( isset( $_GET['tgmpa-dismiss'] ) ) {
            update_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', 1 );
          }
        }
        public function register( $plugin ){
          if( ! isset( $plugin['slug'] ) || ! isset( $plugin['name'] ) ){
            return;
          }
          foreach( $this->plugins as $registered_plugin ){
              if( $plugin['slug'] == $registered_plugin['slug'] ){
                return;
              }
          }
          $this->plugins[] = $plugin;
        }
        public function config( $config ) {
          $keys = array( 'default_path', 'has_notices', 'dismissable', 'dismiss_msg', 'menu', 'is_automatic', 'message', 'strings' );
            foreach ( $keys as $key ) {
              if ( isset( $config[$key] ) ) {
                if ( is_array( $config[$key] ) ) {
                  foreach ( $config[$key] as $subkey => $value ) {
                    $this->{$key}[$subkey] = $value;
                  }
                }else{
                  $this->$key = $config[$key];
                }
              }
            }
        }
        public function actions( $install_actions ){
          // Remove action links on the TGMPA install page.
          if( $this->is_tgmpa_page() ){
            return false;
          }
          return $install_actions;
        }
        public function flush_plugins_cache(){
          wp_cache_flush();
        }
        public function populate_file_path(){
          // Add file_path key for all plugins.
          foreach ( $this->plugins as $plugin => $values ) {
            $this->plugins[$plugin]['file_path'] = $this->_get_plugin_basename_from_slug( $values['slug'] );
          }
        }
        protected function _get_plugin_basename_from_slug( $slug ){
          $keys = array_keys( get_plugins() );
          foreach ( $keys as $key ){
            if( preg_match( '|^' . $slug .'/|', $key ) ){
              return $key;
            }
          }
          return $slug;
        }

        protected function _get_plugin_data_from_name( $name, $data = 'slug' ){
          foreach( $this->plugins as $plugin => $values ){
            if( $name == $values['name'] && isset( $values[$data] ) ){
              return $values[$data];
            }
          }
          return false;
        }
        protected function is_tgmpa_page(){
          if( isset( $_GET['page'] ) && $this->menu === $_GET['page'] ){
            return true;
          }
          return false;
        }
        public function update_dismiss(){
          delete_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice' );
        }
        public function force_activation(){
          $this->populate_file_path();

          $installed_plugins = get_plugins();

          foreach ( $this->plugins as $plugin ) {
            if ( isset( $plugin['force_activation'] ) && $plugin['force_activation'] && ! isset( $installed_plugins[$plugin['file_path']] ) ){
              continue;
            }
            elseif(isset( $plugin['force_activation'] ) && $plugin['force_activation'] && is_plugin_inactive( $plugin['file_path'] ) ){
                  activate_plugin( $plugin['file_path'] );
            }
          }

        }

        public function force_deactivation(){
            // Set file_path parameter for any installed plugins.
          $this->populate_file_path();
          foreach ( $this->plugins as $plugin ) {
            // Only proceed forward if the paramter is set to true and plugin is active.
            if(isset( $plugin['force_deactivation'] ) && $plugin['force_deactivation'] && is_plugin_active( $plugin['file_path'] ) ){
              deactivate_plugins( $plugin['file_path'] );
            }
          }
        }
      public static function get_instance(){
        if( ! isset( self::$instance ) && ! ( self::$instance instanceof TGM_Plugin_Activation ) ){
          self::$instance = new TGM_Plugin_Activation();
        }
        return self::$instance;
      }
    }

    $tgmpa = TGM_Plugin_Activation::get_instance();
}
if( ! function_exists( 'tgmpa' ) ){
  function tgmpa( $plugins, $config = array() ){
    foreach ( $plugins as $plugin ) {
      TGM_Plugin_Activation::$instance->register( $plugin );
    }

    if( $config ){
      TGM_Plugin_Activation::$instance->config( $config );
    }
  }
}
if( ! class_exists( 'WP_List_Table' ) ){
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if( ! class_exists( 'TGMPA_List_Table' ) ){
  class TGMPA_List_Table extends WP_List_Table{
    public function __construct() {
      global $status, $page;
      parent::__construct(
        array(
            'singular' => 'plugin',
            'plural'   => 'plugins',
            'ajax'     => false,
        )
      );
    }
    protected function _gather_plugin_data(){
    TGM_Plugin_Activation::$instance->admin_init();
    TGM_Plugin_Activation::$instance->thickbox();
    $table_data        = array();
    $i                 = 0;
    $installed_plugins = get_plugins();

    foreach ( TGM_Plugin_Activation::$instance->plugins as $plugin ){
      if( is_plugin_active( $plugin['file_path'] ) ){
        continue; // No need to display plugins if they are installed and activated.
      }

      $table_data[$i]['sanitized_plugin'] = $plugin['name'];
      $table_data[$i]['slug']             = $this->_get_plugin_data_from_name( $plugin['name'] );

      $external_url = $this->_get_plugin_data_from_name( $plugin['name'], 'external_url' );
      $source       = $this->_get_plugin_data_from_name( $plugin['name'], 'source' );

      if( $external_url && preg_match( '|^http(s)?://|', $external_url ) ){
          $table_data[$i]['plugin'] = '<strong><a href="' . esc_url( $external_url ) . '" title="' . esc_attr( $plugin['name'] ) . '" target="_blank">' . $plugin['name'] . '</a></strong>';
      }
      elseif( ! $source || preg_match( '|^http://wordpress.org/extend/plugins/|', $source ) ){
        $url = add_query_arg(
          array(
           'tab'       => 'plugin-information',
           'plugin'    => urlencode( $this->_get_plugin_data_from_name( $plugin['name'] ) ),
           'TB_iframe' => 'true',
           'width'     => '640',
           'height'    => '500',
          ),
          network_admin_url( 'plugin-install.php' )
        );

        $table_data[$i]['plugin'] = '<strong><a href="' . esc_url( $url ) . '" class="thickbox" title="' . esc_attr( $plugin['name'] ) . '">' . $plugin['name'] . '</a></strong>';
      }
      else{
        $table_data[$i]['plugin'] = '<strong>' . $plugin['name'] . '</strong>'; // No hyperlink.
      }

      if( isset( $table_data[$i]['plugin'] ) && (array) $table_data[$i]['plugin'] ){
        $plugin['name'] = $table_data[$i]['plugin'];
      }
      if( ! empty( $plugin['source'] ) ){
        if( preg_match( '|^http(s)?://|', $plugin['source'] ) ){
          $table_data[$i]['source'] = __( 'Private Repository', 'tgmpa' );
        }else{
          $table_data[$i]['source'] = __( 'Pre-Packaged', 'tgmpa' );
        }
      }
      else{
        $table_data[$i]['source'] = __( 'WordPress Repository', 'tgmpa' );
      }
      $table_data[$i]['type'] = isset( $plugin['required'] ) && $plugin['required'] ? __( 'Required', 'tgmpa' ) : __( 'Recommended', 'tgmpa' );
        if( ! isset( $installed_plugins[$plugin['file_path']] ) ) {
          $table_data[$i]['status'] = sprintf( '%1$s', __( 'Not Installed', 'tgmpa' ) );
        }elseif ( is_plugin_inactive( $plugin['file_path'] ) ) {
          $table_data[$i]['status'] = sprintf( '%1$s', __( 'Installed But Not Activated', 'tgmpa' ) );
        }

        $table_data[$i]['file_path'] = $plugin['file_path'];
        $table_data[$i]['url']       = isset( $plugin['source'] ) ? $plugin['source'] : 'repo';
        $i++;
    }

    $resort = array();
    $req    = array();
    $rec    = array();
    foreach ( $table_data as $plugin ){
      $resort[] = $plugin['type'];
    }
    foreach ( $resort as $type ){
      if( 'Required' == $type ){
        $req[] = $type;
      }else{
        $rec[] = $type;
      }
    }

    sort( $req );
    sort( $rec );
    array_merge( $resort, $req, $rec );
    array_multisort( $resort, SORT_DESC, $table_data );

    return $table_data;

  }
    protected function _get_plugin_data_from_name( $name, $data = 'slug' ) {

      foreach ( TGM_Plugin_Activation::$instance->plugins as $plugin => $values ) {
        if ( $name == $values['name'] && isset( $values[$data] ) ) {
          return $values[$data];
        }
      }
      return false;
      }
      public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
          case 'source':
          case 'type':
          case 'status':
            return $item[$column_name];
        }
      }
        public function column_plugin( $item ){
          $installed_plugins = get_plugins();
          if( is_plugin_active( $item['file_path'] ) ){
            $actions = array();
          }
          if( ! isset( $installed_plugins[$item['file_path']] ) ){
            $actions = array(
              'install' => sprintf(
                '<a href="%1$s" title="' . esc_attr__( 'Install', 'tgmpa' ) . ' %2$s">' . __( 'Install', 'tgmpa' ) . '</a>',
                esc_url(
                  wp_nonce_url(
                    add_query_arg(
                      array(
                        'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
                        'plugin'        => urlencode( $item['slug'] ),
                        'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
                        'plugin_source' => urlencode( $item['url'] ),
                        'tgmpa-install' => 'install-plugin',
                      ),
                      network_admin_url( 'themes.php' )
                      ),
                      'tgmpa-install'
                  )
                ),
                $item['sanitized_plugin']
              ),
            );
          }
          elseif( is_plugin_inactive( $item['file_path'] ) ){
            $actions = array(
              'activate' => sprintf(
                '<a href="%1$s" title="' . esc_attr__( 'Activate', 'tgmpa' ) . ' %2$s">' . __( 'Activate', 'tgmpa' ) . '</a>',
                esc_url(
                  add_query_arg(
                    array(
                      'page'                 => urlencode( TGM_Plugin_Activation::$instance->menu ),
                      'plugin'               => urlencode( $item['slug'] ),
                      'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
                      'plugin_source'        => urlencode( $item['url'] ),
                      'tgmpa-activate'       => 'activate-plugin',
                      'tgmpa-activate-nonce' => urlencode( wp_create_nonce( 'tgmpa-activate' ) ),
                    ),
                    network_admin_url( 'themes.php' )
                  )
                ),
                $item['sanitized_plugin']
              ),
            );
          }
          return sprintf( '%1$s %2$s', $item['plugin'], $this->row_actions( $actions ) );
        }
        public function column_cb( $item ){
          $plugin_url = $item['url'];
            if( __( 'Private Repository', 'tgmpa' ) === $item['source'] ){
              $plugin_url = esc_url( $plugin_url );
            }elseif ( __( 'Pre-Packaged', 'tgmpa' ) === $item['source'] ){
              $plugin_url = urlencode( TGM_Plugin_Activation::$instance->default_path . $plugin_url );
            }
            $value = $item['file_path'] . ',' . $plugin_url . ',' . $item['sanitized_plugin'];
            return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" id="%3$s" />', esc_attr( $this->_args['singular'] ), esc_attr( $value ), esc_attr( $item['sanitized_plugin'] ) );
        }
        public function no_items(){
          printf( __( 'No plugins to install or activate. <a href="%1$s" title="Return to the Dashboard">Return to the Dashboard</a>', 'tgmpa' ), network_admin_url() );
          echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';
        }
        public function get_columns(){
          $columns = array(
            'cb'     => '<input type="checkbox" />',
            'plugin' => __( 'Plugin', 'tgmpa' ),
            'source' => __( 'Source', 'tgmpa' ),
            'type'   => __( 'Type', 'tgmpa' ),
            'status' => __( 'Status', 'tgmpa' )
          );
            return $columns;
        }
        public function get_bulk_actions(){
          $actions = array(
            'tgmpa-bulk-install'  => __( 'Install', 'tgmpa' ),
            'tgmpa-bulk-activate' => __( 'Activate', 'tgmpa' ),
          );
          return $actions;
        }
        public function process_bulk_actions(){
          if( 'tgmpa-bulk-install' === $this->current_action() ){
            check_admin_referer( 'bulk-' . $this->_args['plural']);

            $plugins_to_install = array();
            $plugin_installs    = array();
            $plugin_path        = array();
            $plugin_name        = array();

            if( isset( $_GET['plugins'] ) ){
              $plugins = explode( ',', stripslashes( $_GET['plugins'] ) );
            }
            elseif( isset( $_POST['plugin'] ) ){
              $plugins = (array) $_POST['plugin'];
            }
            else{
              $plugins = array();
            }
              if( isset( $_POST['plugin'] ) ){
                foreach ( $plugins as $plugin_data ) {
                  $plugins_to_install[] = explode( ',', $plugin_data );
                }
                foreach( $plugins_to_install as $plugin_data ){
                  $plugin_installs[] = $plugin_data[0];
                  $plugin_path[]     = $plugin_data[1];
                  $plugin_name[]     = $plugin_data[2];
                }
              }
              else{
                foreach ( $plugins as $key => $value ) {
                  if ( 0 == $key % 3 || 0 == $key ) {
                    $plugins_to_install[] = $value;
                    $plugin_installs[]    = $value;
                  }
                }
              }
              if( isset( $_GET['plugin_paths'] ) ){
                $plugin_paths = explode( ',', stripslashes( $_GET['plugin_paths'] ) );
              }
              elseif ( isset( $_POST['plugin'] ) ){
                $plugin_paths = (array) $plugin_path;
              }
              else {
                $plugin_paths = array();
              }
              if ( isset( $_GET['plugin_names'] ) ){
                $plugin_names = explode( ',', stripslashes( $_GET['plugin_names'] ) );
              }
              elseif ( isset( $_POST['plugin'] ) ){
                $plugin_names = (array) $plugin_name;
              }
              else{
                $plugin_names = array();
              }
              $i = 0;
              foreach( $plugin_installs as $key => $plugin ){
                if( preg_match( '|.php$|', $plugin ) ){
                  unset( $plugin_installs[$key] );
                  if ( ! isset( $_GET['plugin_paths'] ) )
                  unset( $plugin_paths[$i] );
                  if ( ! isset( $_GET['plugin_names'] ) )
                  unset( $plugin_names[$i] );
                }
                $i++;
              }
              if ( empty( $plugin_installs ) ) {
                return false;
              }
              $plugin_installs = array_values( $plugin_installs );
              $plugin_paths    = array_values( $plugin_paths );
              $plugin_names    = array_values( $plugin_names );
              $plugin_installs = array_map( 'urldecode', $plugin_installs );
              $plugin_paths    = array_map( 'urldecode', $plugin_paths );
              $plugin_names    = array_map( 'urldecode', $plugin_names );
              $url = wp_nonce_url(
                add_query_arg(
                  array(
                    'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
                    'tgmpa-action'  => 'install-selected',
                    'plugins'       => urlencode( implode( ',', $plugins ) ),
                    'plugin_paths'  => urlencode( implode( ',', $plugin_paths ) ),
                    'plugin_names'  => urlencode( implode( ',', $plugin_names ) ),
                  ),
                  network_admin_url( 'themes.php' )
                ),
                'bulk-plugins'
              );
              $method = '';
              $fields = array( 'action', '_wp_http_referer', '_wpnonce' );
                if( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ){
                  return true;
                }
                if( ! WP_Filesystem( $creds ) ){
                  request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );
                  return true;
                }
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

                $api          = array();
                $sources      = array();
                $install_path = array();
                $i = 0;
                foreach ( $plugin_installs as $plugin ) {
                  $api[$i] = plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) ) ? plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) ) : (object) $api[$i] = 'tgmpa-empty';
                  $i++;
                }
                if( is_wp_error( $api ) ){
                  wp_die( TGM_Plugin_Activation::$instance->strings['oops'] . var_dump( $api ) );
                }
                $i = 0;
                foreach( $api as $object ){
                  $sources[$i] = isset( $object->download_link ) && 'repo' == $plugin_paths[$i] ? $object->download_link : $plugin_paths[$i];
                  $i++;
                }
                $url   = esc_url_raw( add_query_arg( array( 'page' => urlencode( TGM_Plugin_Activation::$instance->menu ) ), network_admin_url( 'themes.php' ) ) );
                $nonce = 'bulk-plugins';
                $names = $plugin_names;
                $installer = new TGM_Bulk_Installer( $skin = new TGM_Bulk_Installer_Skin( compact( 'url', 'nonce', 'names' ) ) );
                echo '<div class="tgmpa wrap">';
                  echo '<h2>' . esc_html( get_admin_page_title() ) . '</h2>';
                  $installer->bulk_install( $sources );
                echo '</div>';
                return true;
          }
          if( 'tgmpa-bulk-activate' === $this->current_action() ){
            check_admin_referer( 'bulk-' . $this->_args['plural'] );
            $plugins             = isset( $_POST['plugin'] ) ? (array) $_POST['plugin'] : array();
            $plugins_to_activate = array();

            foreach( $plugins as $i => $plugin ){
              $plugins_to_activate[] = explode( ',', $plugin );
            }

            foreach( $plugins_to_activate as $i => $array ){
              if ( ! preg_match( '|.php$|', $array[0] ) ){
                unset( $plugins_to_activate[$i] );
              }
            }

            if( empty( $plugins_to_activate ) ){
              return;
            }

            $plugins      = array();
            $plugin_names = array();

            foreach ( $plugins_to_activate as $plugin_string ) {
              $plugins[]      = $plugin_string[0];
              $plugin_names[] = $plugin_string[2];
            }

            $count       = count( $plugin_names );
            $last_plugin = array_pop( $plugin_names );
            $imploded    = empty( $plugin_names ) ? '<strong>' . $last_plugin . '</strong>' : '<strong>' . ( implode( ', ', $plugin_names ) . '</strong> and <strong>' . $last_plugin . '</strong>.' );

            $activate = activate_plugins( $plugins );

            if ( is_wp_error( $activate ) ) {
                echo '<div id="message" class="error"><p>' . $activate->get_error_message() . '</p></div>';
            } else {
                printf( '<div id="message" class="updated"><p>%1$s %2$s.</p></div>', _n( 'The following plugin was activated successfully:', 'The following plugins were activated successfully:', $count, 'tgmpa' ), $imploded );
            }

            $recent = (array) get_option( 'recently_activated' );

            foreach ( $plugins as $plugin => $time ) {
              if ( isset( $recent[$plugin] ) ) {
                unset( $recent[$plugin] );
              }
            }

            update_option( 'recently_activated', $recent );
            unset( $_POST );
          }
        }
        public function prepare_items() {
          $per_page              = 100;
          $columns               = $this->get_columns();
          $hidden                = array();
          $sortable              = array();
          $this->_column_headers = array( $columns, $hidden, $sortable );
          $this->process_bulk_actions();
          $this->items = $this->_gather_plugin_data();
        }
    }
}
add_action( 'admin_init', 'tgmpa_load_bulk_installer' );
if ( ! function_exists( 'tgmpa_load_bulk_installer' ) ){
  function tgmpa_load_bulk_installer(){
    if( ! class_exists( 'WP_Upgrader' ) && ( isset( $_GET['page'] ) && TGM_Plugin_Activation::$instance->menu === $_GET['page'] ) ){
      require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        if( ! class_exists( 'TGM_Bulk_Installer' ) ){
          class TGM_Bulk_Installer extends WP_Upgrader {
            public $result;
            public $bulk = false;
            public function bulk_install( $packages ) {
              $this->init();
              $this->bulk = true;
              $this->install_strings();
              if( TGM_Plugin_Activation::$instance->is_automatic ){
                $this->activate_strings();
              }
              $this->skin->header();
              $res = $this->fs_connect( array( WP_CONTENT_DIR, WP_PLUGIN_DIR ) );
              if( ! $res ){
                $this->skin->footer();
                return false;
              }
              $this->skin->bulk_header();
              $results = array();
              $this->update_count   = count( $packages );
              $this->update_current = 0;
              foreach ( $packages as $plugin ) {
                $this->update_current++;
                $result = $this->run(
                  array(
                    'package'           => $plugin, // The plugin source.
                    'destination'       => WP_PLUGIN_DIR, // The destination dir.
                    'clear_destination' => false, // Do we want to clear the destination or not?
                    'clear_working'     => true, // Remove original install file.
                    'is_multi'          => true, // Are we processing multiple installs?
                    'hook_extra'        => array( 'plugin' => $plugin, ), // Pass plugin source as extra data.
                  )
                );
                $results[$plugin] = $this->result;
                if( false === $result ){
                  break;
                }
              }
              $this->skin->bulk_footer();
              $this->skin->footer();
              return $results;
            }
            public function run( $options ) {
              $defaults = array(
                'package'           => '',
                'destination'       => '',
                'clear_destination' => false,
                'clear_working'     => true,
                'is_multi'          => false,
                'hook_extra'        => array(),
              );
              $options = wp_parse_args( $options, $defaults );
              extract( $options );
              $res = $this->fs_connect( array( WP_CONTENT_DIR, $destination ) );
              if( ! $res ){
                return false;
              }

              if( is_wp_error( $res ) ){
                $this->skin->error( $res );
                return $res;
              }
              if( ! $is_multi )
                $this->skin->header();
                $this->skin->before();
                $download = $this->download_package( $package );
              if( is_wp_error( $download ) ){
                $this->skin->error( $download );
                $this->skin->after();
                return $download;
              }

              $delete_package = ( $download != $package );
              $working_dir = $this->unpack_package( $download, $delete_package );
              if( is_wp_error( $working_dir ) ){
                $this->skin->error( $working_dir );
                $this->skin->after();
                return $working_dir;
              }
              $result = $this->install_package(
                array(
                  'source'            => $working_dir,
                  'destination'       => $destination,
                  'clear_destination' => $clear_destination,
                  'clear_working'     => $clear_working,
                  'hook_extra'        => $hook_extra,
                )
              );

              $this->skin->set_result( $result );

              if( is_wp_error( $result ) ) {
                $this->skin->error( $result );
                $this->skin->feedback( 'process_failed' );
              }
              else{
                $this->skin->feedback( 'process_success' );
              }
              if( TGM_Plugin_Activation::$instance->is_automatic ){
                wp_cache_flush();
                $plugin_info = $this->plugin_info( $package );
                $activate    = activate_plugin( $plugin_info );
                TGM_Plugin_Activation::$instance->populate_file_path();
                if( is_wp_error( $activate ) ){
                  $this->skin->error( $activate );
                  $this->skin->feedback( 'activation_failed' );
                }
                else{
                  $this->skin->feedback( 'activation_success' );
                }
              }
              wp_cache_flush();
              $this->skin->after();
              if( ! $is_multi ){
                $this->skin->footer();
              }
              return $result;
          }
          public function install_strings() {
            $this->strings['no_package']          = __( 'Install package not available.', 'tgmpa' );
            $this->strings['downloading_package'] = __( 'Downloading install package from <span class="code">%s</span>&#8230;', 'tgmpa' );
            $this->strings['unpack_package']      = __( 'Unpacking the package&#8230;', 'tgmpa' );
            $this->strings['installing_package']  = __( 'Installing the plugin&#8230;', 'tgmpa' );
            $this->strings['process_failed']      = __( 'Plugin install failed.', 'tgmpa' );
            $this->strings['process_success']     = __( 'Plugin installed successfully.', 'tgmpa' );
          }

          public function activate_strings(){
            $this->strings['activation_failed']  = __( 'Plugin activation failed.', 'tgmpa' );
            $this->strings['activation_success'] = __( 'Plugin activated successfully.', 'tgmpa' );
          }
          public function plugin_info() {
            if( ! is_array( $this->result ) ){
              return false;
            }
            if( empty( $this->result['destination_name'] ) ){
              return false;
            }
            $plugin = get_plugins( '/' . $this->result['destination_name'] );
            if ( empty( $plugin ) ) {
              return false;
            }
            $pluginfiles = array_keys( $plugin );
            return $this->result['destination_name'] . '/' . $pluginfiles[0];
          }
        }
      }
      if ( ! class_exists( 'TGM_Bulk_Installer_Skin' ) ) {
        class TGM_Bulk_Installer_Skin extends Bulk_Upgrader_Skin {
          public $plugin_info = array();
          public $plugin_names = array();
          public $i = 0;
          public function __construct( $args = array() ) {
            $defaults = array( 'url' => '', 'nonce' => '', 'names' => array() );
            $args     = wp_parse_args( $args, $defaults );

            $this->plugin_names = $args['names'];

            parent::__construct( $args );

          }
          public function add_strings() {
            if ( TGM_Plugin_Activation::$instance->is_automatic ) {
              $this->upgrader->strings['skin_upgrade_start']        = __( 'The installation and activation process is starting. This process may take a while on some hosts, so please be patient.', 'tgmpa' );
              $this->upgrader->strings['skin_update_successful']    = __( '%1$s installed and activated successfully.', 'tgmpa' ) . ' <a onclick="%2$s" href="#" class="hide-if-no-js"><span>' . __( 'Show Details', 'tgmpa' ) . '</span><span class="hidden">' . __( 'Hide Details', 'tgmpa' ) . '</span>.</a>';
              $this->upgrader->strings['skin_upgrade_end']          = __( 'All installations and activations have been completed.', 'tgmpa' );
              $this->upgrader->strings['skin_before_update_header'] = __( 'Installing and Activating Plugin %1$s (%2$d/%3$d)', 'tgmpa' );
            }
            else {
              $this->upgrader->strings['skin_upgrade_start']        = __( 'The installation process is starting. This process may take a while on some hosts, so please be patient.', 'tgmpa' );
              $this->upgrader->strings['skin_update_failed_error']  = __( 'An error occurred while installing %1$s: <strong>%2$s</strong>.', 'tgmpa' );
              $this->upgrader->strings['skin_update_failed']        = __( 'The installation of %1$s failed.', 'tgmpa' );
              $this->upgrader->strings['skin_update_successful']    = __( '%1$s installed successfully.', 'tgmpa' ) . ' <a onclick="%2$s" href="#" class="hide-if-no-js"><span>' . __( 'Show Details', 'tgmpa' ) . '</span><span class="hidden">' . __( 'Hide Details', 'tgmpa' ) . '</span>.</a>';
              $this->upgrader->strings['skin_upgrade_end']          = __( 'All installations have been completed.', 'tgmpa' );
              $this->upgrader->strings['skin_before_update_header'] = __( 'Installing Plugin %1$s (%2$d/%3$d)', 'tgmpa' );
            }
          }
          public function before( $title = '' ){
            $this->in_loop = true;

            printf( '<h4>' . $this->upgrader->strings['skin_before_update_header'] . ' <img alt="" src="' . admin_url( 'images/wpspin_light.gif' ) . '" class="hidden waiting-' . $this->upgrader->update_current . '" style="vertical-align:middle;" /></h4>', $this->plugin_names[$this->i], $this->upgrader->update_current, $this->upgrader->update_count );
            echo '<script type="text/javascript">jQuery(\'.waiting-' . esc_js( $this->upgrader->update_current ) . '\').show();</script>';
            echo '<div class="update-messages hide-if-js" id="progress-' . esc_attr( $this->upgrader->update_current ) . '"><p>';

            $this->before_flush_output();
          }
          public function after( $title = '' ){
            echo '</p></div>';
              if( $this->error || ! $this->result ){
                if( $this->error ){
                    echo '<div class="error"><p>' . sprintf( $this->upgrader->strings['skin_update_failed_error'], $this->plugin_names[$this->i], $this->error ) . '</p></div>';
                }else{
                  echo '<div class="error"><p>' . sprintf( $this->upgrader->strings['skin_update_failed'], $this->plugin_names[$this->i] ) . '</p></div>';
                }
                echo '<script type="text/javascript">jQuery(\'#progress-' . esc_js( $this->upgrader->update_current ) . '\').show();</script>';
              }
              if( ! empty( $this->result ) && ! is_wp_error( $this->result ) ){
                echo '<div class="updated"><p>' . sprintf( $this->upgrader->strings['skin_update_successful'], $this->plugin_names[$this->i], 'jQuery(\'#progress-' . esc_js( $this->upgrader->update_current ) . '\').toggle();jQuery(\'span\', this).toggle(); return false;' ) . '</p></div>';
                echo '<script type="text/javascript">jQuery(\'.waiting-' . esc_js( $this->upgrader->update_current ) . '\').hide();</script>';
              }
              $this->reset();
              $this->after_flush_output();
          }
          public function bulk_footer() {
            parent::bulk_footer();
            wp_cache_flush();
            $complete = array();
            foreach ( TGM_Plugin_Activation::$instance->plugins as $plugin ){
              if( ! is_plugin_active( $plugin['file_path'] ) ){
                echo '<p><a href="' . esc_url( add_query_arg( 'page', urlencode( TGM_Plugin_Activation::$instance->menu ), network_admin_url( 'themes.php' ) ) ) . '" title="' . esc_attr( TGM_Plugin_Activation::$instance->strings['return'] ) . '" target="_parent">' . TGM_Plugin_Activation::$instance->strings['return'] . '</a></p>';
                $complete[] = $plugin;
                break;
              }
              else {
                $complete[] = '';
              }
            }
            $complete = array_filter( $complete );
              if ( empty( $complete ) ) {
                echo '<p>' .  sprintf( TGM_Plugin_Activation::$instance->strings['complete'], '<a href="' . esc_url( network_admin_url() ) . '" title="' . esc_attr__( 'Return to the Dashboard', 'tgmpa' ) . '">' . __( 'Return to the Dashboard', 'tgmpa' ) . '</a>' ) . '</p>';
                echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';
              }
          }
          public function before_flush_output(){
            wp_ob_end_flush_all();
            flush();
          }
          public function after_flush_output() {
          wp_ob_end_flush_all();
          flush();
          $this->i++;
          }
        }
      }
    }
  }
}