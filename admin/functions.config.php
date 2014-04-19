<?php
/**
	ReduxFramework Sample Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_wpimagehover_config" ) ) {
	/*
	 * Fix issue with custom post types
	 * Load custom config last
	 */
	add_action( 'init', 'wpimagehover_settings_init', 999 );
	function wpimagehover_settings_init()
	{
	    new Redux_Framework_wpimagehover_config();
	}

	class Redux_Framework_wpimagehover_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {


			// Set the default arguments
			$this->setArguments();
			
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
			

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
			
			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.

			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			
			// Change the default value of a field after it's been set, but before it's been used
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

			// Dynamically add a section. Can be also used to modify sections/fields
			add_filter('redux/options/'.$this->args['opt_name'].'/sections', array( $this, 'dynamic_section' ) );
			add_action('redux/options/' . $this->args['opt_name'] . '/validate',  array( $this, "on_redux_save" ) );
			add_action('redux/options/' . $this->args['opt_name'] . '/saved',  array( $this, "on_redux_save" ) );
			do_action( "redux-saved-{$this->args['opt_name']}", array( $this, "on_redux_save" ) );
			//add entypo font
			add_action( 'redux/page/'. $this->args['opt_name'] .'/enqueue', array( $this, 'wpimagehover_entypo' ) );
		}


		/**

			This is a test function that will let you see when the compiler hook occurs. 
			It only runs if a field	set with compiler=>true is changed.

		**/

		function compiler_action($options, $css) {
			echo "<h1>The compiler hook has run!";
			//print_r($options); //Option values
			
			// print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
			/*
			// Demo of how to use the dynamic CSS and write your own static CSS file
		    $filename = dirname(__FILE__) . '/style' . '.css';
		    global $wp_filesystem;
		    if( empty( $wp_filesystem ) ) {
		        require_once( ABSPATH .'/wp-admin/includes/file.php' );
		        WP_Filesystem();
		    }

		    if( $wp_filesystem ) {
		        $wp_filesystem->put_contents(
		            $filename,
		            $css,
		            FS_CHMOD_FILE // predefined mode settings for WP files
		        );
		    }
			*/
		}

		/*
		 * Add Entypo Icon
		 */
		function wpimagehover_entypo() {
			// Uncomment this to remove elusive icon from the panel completely
			//wp_deregister_style( 'redux-elusive-icon' );
			//wp_deregister_style( 'redux-elusive-icon-ie7' );

		    wp_register_style(
		        'wpimagehover-entypo',
		        plugins_url( '../lib/fonts/entypo.css' , __FILE__ ),
		        array(),
		        time(),
		        'all'
		    );	
		    wp_enqueue_style( 'wpimagehover-entypo' );
		}



		/**
		 
		 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 	Simply include this function in the child themes functions.php file.
		 
		 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 	so you must use get_template_directory_uri() if you want to use any of the built in icons
		 
		 **/

		function dynamic_section($sections){
		    //$sections = array();
		    $sections[] = array(
		        'title' => __('Section via hook', 'wpimagehover'),
		        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'wpimagehover'),
				'icon' => 'el-icon-paper-clip',
				    // Leave this as a blank section, no options just some intro text set above.
		        'fields' => array()
		    );

		    return $sections;
		}
		
		
		/**

			Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

		**/
		
		function change_arguments($args){
		    //$args['dev_mode'] = true;
		    
		    return $args;
		}
			
		
		/**

			Filter hook for filtering the default value of any given field. Very useful in development mode.

		**/

		function change_defaults($defaults){
		    $defaults['str_replace'] = "Testing filter hook!";
		    
		    return $defaults;
		}


		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {
			
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
			}

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	

		}


		public function setSections() {

			/**
			 	Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 **/

			$this->sections[] = array(
				'title' => __('Appearance Settings', 'wpimagehover'),
				'desc' => __('Customize the Image hover display to match yout current theme.', 'wpimagehover'),
				'icon' => 'el-icon-eye-open',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
								array(
			                        'id'        => 'image-overlay',
			                        'type'      => 'color',
			                        'title'     => __('Image Hover Overlay Color', 'wpimagehover'),
			                        'subtitle'  => __('Select Custom Color for onHover Overlay for the images'),
			                        'default'   => '#2C3F5C',
			                        'validate'  => 'color',
			                    ),
							),
			);
		
			//remove button settings
			// Upgrade to Pro version to get this feature

			$socials = apply_filters('wpimagehover-socials',array()); // REMOVE LATER
            $socials = apply_filters('wpimagehover/socials',$socials);
            $socials_defaults = array();
            foreach ($socials as $socials_key => $socials_value) {
            	$socials_defaults[ $socials_key ] = '1';
            }
			
			$this->sections[] = array(
				'title' => __('Social Settings', 'wpimagehover'),
				'desc' => __('Select and customize social profiles you want to show on image hover', 'wpimagehover'),
				'icon' => 'el-icon-star',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
								array(
									'id'=>'social_display',
									'type' => 'switch', 
									'title' => __('Display Social Links', 'wpimagehover'),
									'subtitle'=> __('Show social link/icons on image hover', 'wpimagehover'),
									"default" 		=> 1,
									),
								array(
									'id'=>'social_style',
									'type' => 'select',
									'title' => __('Social Link Style', 'wpimagehover'), 
									'subtitle'=> __('Select social link/icon style', 'wpimagehover'),
									'options' => array('circle'=>'Circle', 'square'=>'Square'),
									'default' => 'circle',
									),
								array(
									'id'=>'social_color',
									'type' => 'select',
									'title' => __('Social Link Color', 'wpimagehover'), 
									'subtitle'=> __('Select social link/icon style', 'wpimagehover'),
									'desc' => __('Upgrade to <a href="http://codecanyon.net/item/wordpress-image-hover-showcase/7455102?ref=phpbits" target="_blank">Wordpress Image Hover Showcase</a> to enable custom color option and other cool features.', 'wpimagehover'), 
									'options' => array('colored'=>'Colored'),
									'default' => 'colored',
									),
								
								array(
									'id'=>'socials',
									'type' => 'checkbox',
                					// 'mode' => 'checkbox', // checkbox or text
									'title' => __('Social Profiles', 'wpimagehover'), 
									'subtitle' => __('Select Social Media Profile allowed on image hover', 'wpimagehover'),
									'options' => $socials, //Must provide key => value pairs for multi checkbox options
									'default' => $socials_defaults, //See how std has changed? you also don't need to specify opts that are 0.
								),
				)
			);
			
			$this->sections[] = array(
				'title' => __('Animation Settings', 'wpimagehover'),
				'desc' => __('Upgrade to <a href="http://codecanyon.net/item/wordpress-image-hover-showcase/7455102?ref=phpbits" target="_blank">Wordpress Image Hover Showcase</a> for more animation options and other cool features.', 'wpimagehover'),
				'icon' => 'el-icon-cog',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
								array(
									'id'=>'animation_hover',
									'type' => 'select',
									'title' => __('Default Hover Animation', 'wpimagehover'), 
									'subtitle'=> __('Select default on hover image animation', 'wpimagehover'),
									'options' => array(
													'fade' => 'Fade'
												),
									'default' => 'fade',
								)
					)
			);

		}	

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
			    'id' => 'redux-opts-1',
			    'title' => __('Theme Information 1', 'wpimagehover'),
			    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'wpimagehover')
			);

			$this->args['help_tabs'][] = array(
			    'id' => 'redux-opts-2',
			    'title' => __('Theme Information 2', 'wpimagehover'),
			    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'wpimagehover')
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'wpimagehover');

		}


		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'wpimagehover_lite', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> __('WP Image Hover Lite','wpimagehover'), // Name that appears at the top of your panel
				'display_version'		=> '1.0', // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> __( 'WP Image Hover Lite', 'wpimagehover' ),
	            'page'		 	 		=> __( 'WP Image Hover Lite', 'wpimagehover' ),
	            'google_api_key'   	 	=> '', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> false, // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> '_wpimagehover_options', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> false, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // __( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
			$this->args['share_icons'][] = array(
			    'url' => 'http://codecanyon.net/user/phpbits?ref=phpbits',
			    'title' => 'Follow me on Envato', 
			    'icon' => 'el-icon-user'
			);

			
	 
			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false ) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				$this->args['intro_text'] = sprintf( __('<p>Increase social sharing to boost your website traffic with Wordpress Image Hover. If you decide to upgrade to <a href="http://codecanyon.net/item/wordpress-image-hover-showcase/7455102?ref=phpbits" target="_blank"><strong>Wordpress Image Hover Showcase</strong></a>, please deactivate Wordpress Image Hover Lite first.</p>', 'wpimagehover' ), $v );
			} else {
				$this->args['intro_text'] = __('<p>Increase social sharing to boost your website traffic with Wordpress Image Hover. If you decide to upgrade to <a href="http://codecanyon.net/item/wordpress-image-hover-showcase/7455102?ref=phpbits" target="_blank"><strong>Wordpress Image Hover Showcase</strong></a>, please deactivate Wordpress Image Hover Lite first.</p>', 'wpimagehover' );
			}

			// Add content after the form.
			$this->args['footer_text'] = __('<p>If you need any help feel free to contact me using my <a href="http://codecanyon.net/user/phpbits?ref=phpbits" target="_blank">profile page.</a></p>', 'wpimagehover');

		}
		
		public static function on_redux_save( $values ) {
	        // var_dump($values);
	        // die("SAVED");   
	    }
	}
}


/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'wpimagehover_custom_field' ) ):
	function wpimagehover_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'wpimagehover_validate_callback_function' ) ):
	function wpimagehover_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    /*
	    do your validation
	    
	    if(something) {
	        $value = $value;
	    } elseif(something else) {
	        $error = true;
	        $value = $existing_value;
	        $field['msg'] = 'your custom error message';
	    }
	    */
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
