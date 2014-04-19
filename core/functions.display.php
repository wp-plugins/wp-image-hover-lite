<?php
/*##################################
	AUTHOR BOX DISPLAY
################################## */

class wpimagehover_display{
	public $post;
	public $settings;

	function __construct(){
		global $post;
		global $settings;

		add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );
		add_action( 'wp_footer', array($this, 'js'), 999 );
		add_action( 'wp_footer', array($this, 'css'), 999 );

		add_action( 'wp_footer', create_function( '',
		   'echo \'<!--[if lt IE 10]><script src="'. plugins_url( 'js/wpimagehover-ie.js' , dirname(__FILE__) ) .'"></script><![endif]-->\';'
		) );
	}

	function enqueue(){
		global $wpimagehover_lite;
		$this->settings = $wpimagehover_lite;

		wp_enqueue_style( 'css-wpimagehover', plugins_url( 'css/wpimagehover.css' , dirname(__FILE__) ) , array(), null );
		wp_enqueue_style( 'elusive-icon', plugins_url( 'includes/redux-framework/ReduxCore/assets/css/vendor/elusive-icons/elusive-webfont.css' , dirname(__FILE__) ) , array(), null );

		wp_register_script(
			'jquery-wpimagehover',
			plugins_url( 'js/wpimagehover.js' , dirname(__FILE__) ),
			array( 'jquery' ),
			'',
			true
		);
		wp_register_script(
			'jquery-sharrre',
			plugins_url( 'includes/Sharrre-master/jquery.sharrre.min.js' , dirname(__FILE__) ),
			array( 'jquery' ),
			'',
			true
		);

		wp_enqueue_script('jquery-wpimagehover');
		wp_enqueue_script('jquery-sharrre');
	}
	function js(){ ?>
		<script>
			jQuery(window).load(function($){
				jQuery('.wpimagehover').wpimagehover({
					<?php if(!$this->settings['social_display']) : ?>
					'noSocials' : true,
					<?php endif;?>
					'animation' : '<?php echo $this->settings["animation_hover"]?>',
					'socialType' : '<?php echo $this->settings["social_color"]?>',
					'socialStyle' : '<?php echo $this->settings["social_style"]?>'
				});
				jQuery('.wpimagehover-socials a').on('click',function(e){
					e.preventDefault();
				});
				<?php if($this->settings['social_display']) : ?>
				jQuery('.wpimagehover-twitter').sharrre({
				  share: {
				    twitter: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: {  },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('twitter');
				  }
				});

				jQuery('.wpimagehover-facebook').sharrre({
				  share: {
				    facebook: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: {  },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('facebook');
				  }
				});

				jQuery('.wpimagehover-linkedin').sharrre({
				  share: {
				    facebook: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: {  },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('linkedin');
				  }
				});

				jQuery('.wpimagehover-pinterest').sharrre({
				  share: {
				    facebook: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: { },
				  click: function(api, options){
				  	options.buttons.pinterest.description = jQuery(this).get(0).text;
				  	options.buttons.pinterest.media = jQuery(this).get(0).title;
				    api.simulateClick();
				    api.openPopup('pinterest');
				  }
				});

				jQuery('.wpimagehover-googleplus').sharrre({
				  share: {
				    googlePlus: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: { },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('googlePlus');
				  }
				});
				jQuery('.wpimagehover-digg').sharrre({
				  share: {
				    digg: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: {  },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('digg');
				  }
				});

				jQuery('.wpimagehover-delicious').sharrre({
				  share: {
				    delicious: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: {  },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('delicious');
				  }
				});

				jQuery('.wpimagehover-stumbleupon').sharrre({
				  share: {
				    stumbleupon: true
				  },
				  urlCurl: "<?php echo plugins_url( 'includes/Sharrre-master/sharrre.php' , dirname(__FILE__) );?>",
				  enableHover: false,
				  enableTracking: false,
				  enableCounter: false,
				  buttons: {  },
				  click: function(api, options){
				    api.simulateClick();
				    api.openPopup('stumbleupon');
				  }
				});
				<?php endif;?>
			});
		</script>
	<?php }
	function css(){?>
		<style type="text/css">
			.wpimagehover-wrapper .wpimagehover-overlay{
				background-color: <?php echo $this->settings['image-overlay']?>;
			}
		</style>
	<?php }
	
}
$wpimagehover_lite_display = new wpimagehover_display();
?>