<?PHP

// Boostrap WP
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}

// let's load WordPress
require($wp_include);

// $icons_file = ReduxFramework::$_dir.'inc/fields/select/elusive-icons.php';
// if( file_exists($icons_file) ){
// 	require_once( $icons_file );
// }

// $icons = apply_filters('redux-font-icons',array()); // REMOVE LATER
// $icons = apply_filters('redux/font-icons',$icons);
// Get Options from DB
//$tc = get_option('');
global $wpimagehover_lite;
//print_r($wpimagehover_lite);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php _e('Wordpress Image Hover Lite','wpimagehover')?></title>

<link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/plugins/wpeditimage/css/editimage.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-includes/css/buttons.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-admin/css/colors.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo plugins_url( '../../js/select2-3.4.6/select2.css', __FILE__ ); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo plugins_url( '../../includes/redux-framework/ReduxCore/assets/css/vendor/elusive-icons/elusive-webfont.css', __FILE__ ); ?>" type="text/css" media="all" />
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<script language="javascript" src="<?php echo plugins_url( '../../js/select2-3.4.6/select2.min.js', __FILE__ ); ?>"></script>

<style>
	body{
		/*margin: 0px;*/
	}
	#sidemenu{
		padding: 0px;
	}
	#sidemenu a{
		border-bottom: 0px;
	}
	#sidemenu a.current{
		padding-bottom: 4px;
	}
	table{
		width: 100%;
	}
	table th.label{
		vertical-align: middle;
		width: 140px;
	}
	table tr{
		margin-top: 2px;
		display: block;
	}
	.describe input[type="text"], .describe textarea{
		width: 400px;
	}
	table tr td{
		/*width: 60%;*/
	}
	.panel{
		display: none;
	}
	.panel.current{
		display: block;
	}
	.panel_wrapper div.current{
		height: auto;
	}
	#wpimagehover-dialog{
		border: 1px solid #dfdfdf;
		margin: 15px auto;
	}
	.wp-core-ui .button{
		height: 30px;
		font-size: 13px;
		line-height: 28px;
		padding: 0 12px 2px;
	}
	.select2-container{
		width: 300px;
	}
	input[type=checkbox], input[type=radio] {
		border-width: 1px;
		border-style: solid;
		clear: none;
		cursor: pointer;
		display: inline-block;
		line-height: 0;
		height: 16px;
		margin: -4px 4px 0 0;
		outline: 0;
		padding: 0!important;
		text-align: center;
		vertical-align: middle;
		width: 16px;
		min-width: 16px;
		-webkit-appearance: none;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}
	input[type=checkbox]:checked {
		/*background-color: #1e8cbe;
		border-width: 3px;*/
		-webkit-appearance: checkbox;
	   -moz-appearance:    checkbox;
	   appearance:         checkbox;
	}
	#sidemenu li.current a{
		-webkit-border-top-left-radius: 4px;
		border-top-left-radius: 4px;
		-webkit-border-top-right-radius: 4px;
		border-top-right-radius: 4px;
		border-style: solid;
		border-width: 1px;
		background-color: #f1f1f1;
		border-color: #dfdfdf #dfdfdf #f1f1f1;
		color: #000;
	}
</style>

<script language="javascript" type="text/javascript">

	jQuery(document).ready(function($) {
	
		jQuery('.mctab-to-js').on('click',function(e){
			var target_id= $(this).data('id');
			$('#media-upload-header #sidemenu li').each(function(){
				var getid = $(this).find('.mctab-to-js').data('id');
				if(getid == target_id){
					$(this).addClass('current');
				}else{
					$(this).removeClass('current');
				}
			});
			$('div.panel').each(function(){
				var getid = $(this).attr('id');
				if(getid == target_id){
					$(this).addClass('current');
				}else{
					$(this).removeClass('current');
				}
				
			});
			e.preventDefault();
		});

		var html, editor, self = this;

			self.editor = editor = tinyMCEPopup.editor;
			var selection = self.editor.selection.getNode();
			var selectionNode = $( selection );
			//console.log( selectionNode.data('mceSrc') );
			$('#dummy #imgurl').val( selectionNode.data('mceSrc') );
			$('#dummy #imgclass').val( selectionNode.attr('class') );
			$('#dummy #imgalt').val( selectionNode.attr('alt') );
			$('#dummy #imgtitle').val( selectionNode.attr('title') );
			$('#dummy #imgwidth').val( selectionNode.attr('width') );
			$('#dummy #imgheight').val( selectionNode.attr('height') );

			if( selectionNode.data('mceSrc') === undefined ){
				alert('Please Select an Image First. Thanks!');
				// $('.mceClose').click();
			}
			
			var getData = selectionNode.data();
			//console.log(getData);

			$.each(getData, function(k,v){
				switch(k){
					case 'fburl':
						$('#social_facebook').val( v );
					break;
					case 'tweeturl':
						$('#social_twitter').val( v );
					break;
					case 'linkedinurl':
						$('#social_linkedin').val( v );
					break;
					case 'pinurl':
						$('#social_pinterest').val( v );
					break;
					case 'plusurl':
						$('#social_googleplus').val( v );
					break;
					case 'diggurl':
						$('#social_digg').val( v );
					break;
					case 'deliciousurl':
						$('#social_delicious').val( v );
					break;
					case 'stumbleuponurl':
						$('#social_stumbleupon').val( v );
					break;
					case 'btntext':
						$('#button_text').val( v );
					break;
					case 'btnicon':
						$('#button_icon').val( v );
					break;
					case 'btnlink':
						$('#button_url').val( v );
					break;
					case 'btntarget':
						$('#button_target').val( v );
					break;
					case 'animation':
						$('#animation_hover').val( v );
					break;
					case 'sharetxt':
						$('#general_text').val( v );
					break;
					default:
					break;
				}
			});

			if( !getData.hasOwnProperty('fburl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_facebook').removeAttr('checked');	
			}else if( getData.hasOwnProperty('fburl') ){
				$('#show_facebook').attr('checked', 'checked');
			}

			if( !getData.hasOwnProperty('tweeturl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_twitter').removeAttr('checked');	
			}else if( getData.hasOwnProperty('tweeturl') ){
				$('#show_twitter').attr('checked', 'checked');
			}

			if( !getData.hasOwnProperty('linkedinurl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_linkedin').removeAttr('checked');	
			}else if( getData.hasOwnProperty('linkedinurl') ){
				$('#show_linkedin').attr('checked', 'checked');
			}

			if( !getData.hasOwnProperty('pinurl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_pinterest').removeAttr('checked');	
			}else if( getData.hasOwnProperty('pinurl') ){
				$('#show_pinterest').attr('checked', 'checked');	
			}

			if( !getData.hasOwnProperty('plusurl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_googleplus').removeAttr('checked');	
			}else if( getData.hasOwnProperty('plusurl') ){
				$('#show_googleplus').attr('checked', 'checked');
			}

			if( !getData.hasOwnProperty('deliciousurl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_delicious').removeAttr('checked');	
			}else if( getData.hasOwnProperty('deliciousurl') ){
				$('#show_delicious').attr('checked', 'checked');	
			}

			if( !getData.hasOwnProperty('diggurl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_digg').removeAttr('checked');	
			}else if( getData.hasOwnProperty('diggurl') ){
				$('#show_digg').attr('checked', 'checked');
			}

			if( !getData.hasOwnProperty('stumbleuponurl') && selectionNode.hasClass('wpimagehover') ){
				$('#show_stumbleupon').removeAttr('checked');	
			}else if( getData.hasOwnProperty('stumbleuponurl') ){
				$('#show_stumbleupon').attr('checked', 'checked');
			}
		
		window.send_to_editor = function(html) {
			 imgurl = jQuery('img',html).attr('src');
			 jQuery('#upload_image').val(imgurl);
			 tb_remove();
		}

		$(".panel_wrapper .toselect2").select2();
		function format(state) {
		    if (!state.id) return state.text; // optgroup
		    return "<i class='" + state.id + "'></i> " + state.text;
		}
	
	});


	// Start TinyMCE
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}
	
	
	// Function to auto-get image size
	function updateSize(){
		var imageUrl = document.getElementById('tcsh-image').value;
		jQuery('<img/>').attr('src', imageUrl).load(function(){
			rwidth = this.width;   // Note: $(this).width() will not
			rheight = this.height; // work for in memory images.
			document.getElementById('tcsh-width').value = rwidth;
			document.getElementById('tcsh-height').value = rheight;
		});
	}
	
	
	// Function to add the like locker shortcode to the editor
	function addImage(){
		
		// Cache our form vars
		var imgurl = document.getElementById('imgurl').value;
		var imgclass = document.getElementById('imgclass').value;
		var imgalt = document.getElementById('imgalt').value;
		var imgtitle = document.getElementById('imgtitle').value;
		var imgwidth = document.getElementById('imgwidth').value;
		var imgheight = document.getElementById('imgheight').value;

		//general
		var sharetxt = checkValue('general_text');
		var animation = checkValue('animation_hover');

		//social styles
		var social_style = checkValue('social_style');

		//social data values
		var fburl = checkValue('social_facebook');
		var tweeturl = checkValue('social_twitter');
		var linkedinurl = checkValue('social_linkedin');
		var pinurl = checkValue('social_pinterest');
		var plusurl = checkValue('social_googleplus');
		var diggurl = checkValue('social_digg');
		var deliciousurl = checkValue('social_delicious');
		var stumbleuponurl = checkValue('social_stumbleupon');

		//social visibility
		var show_fburl = checkboxValue('show_facebook');
		var show_tweeturl = checkboxValue('show_twitter');
		var show_linkedinurl = checkboxValue('show_linkedin');
		var show_pinurl = checkboxValue('show_pinterest');
		var show_plusurl = checkboxValue('show_googleplus');
		var show_diggurl = checkboxValue('show_digg');
		var show_deliciousurl = checkboxValue('show_delicious');
		var show_stumbleuponurl = checkboxValue('show_stumbleupon');

		
		imgtag = '<img src="'+imgurl+'" class="wpimagehover ';
		if( imgclass.length > 0 ){
			imgtag += imgclass.replace('wpimagehover ', '');
		}
		imgtag += '"';

		if(fburl.length > 0 && show_fburl.length > 0){
			imgtag += ' data-fburl="'+ fburl +'"';
		}
		if(tweeturl.length > 0 && show_tweeturl.length > 0){
			imgtag += ' data-tweeturl="'+ tweeturl +'"';
		}
		if(linkedinurl.length > 0 && show_linkedinurl.length > 0){
			imgtag += ' data-linkedinurl="'+ linkedinurl +'"';
		}
		if(pinurl.length > 0 && show_pinurl.length > 0){
			imgtag += ' data-pinurl="'+ pinurl +'"';
		}
		if(plusurl.length > 0 && show_plusurl.length > 0){
			imgtag += ' data-plusurl="'+ plusurl +'"';
		}
		if(diggurl.length > 0 && show_diggurl.length > 0){
			imgtag += ' data-diggurl="'+ diggurl +'"';
		}
		if(deliciousurl.length > 0 && show_deliciousurl.length > 0){
			imgtag += ' data-deliciousurl="'+ deliciousurl +'"';
		}
		if(stumbleuponurl.length > 0 && show_stumbleuponurl.length > 0){
			imgtag += ' data-stumbleuponurl="'+ stumbleuponurl +'"';
		}
		if(social_style.length > 0){
			imgtag += ' data-sstyle="'+ social_style +'"';
		}

		if(sharetxt.length > 0){
			imgtag += ' data-sharetxt="'+ sharetxt.replace('"',"'") +'"';
		}

		if(animation.length > 0){
			imgtag += ' data-animation="'+ animation +'"';
		}

		if(imgtitle.length > 0){
			imgtag += ' title="'+ imgtitle +'"';
		}

		if(imgwidth.length > 0){
			imgtag += ' width="'+ imgwidth +'"';
		}

		if(imgheight.length > 0){
			imgtag += ' height="'+ imgheight +'"';
		}

		imgtag += '/>';

		//'" data-fburl="'+fburl+'" data-tweeturl="'+tweeturl+'" alt="'+ imgalt +'"/>';
			
		// If TinyMCE runable
		if(window.tinyMCE) {
			
			// Get the selected text in the editor
			selected = tinyMCE.activeEditor.selection.getContent();
			
			// Send our modified shortcode to the editor with selected content				
			// window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, imgtag);
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, imgtag);
			// Repaints the editor
			tinyMCEPopup.editor.execCommand('mceRepaint');
			
			// Close the TinyMCE popup
			tinyMCEPopup.close();
			
		} // end if
		
		return; // always R E T U R N

	} // end add like locker function

	function checkValue(id){
		var getEl = document.getElementById(id);
		if (getEl != null){
			assignVal = getEl.value;
		}else{
			assignVal = '';
		}
		return assignVal;
	}

	function checkboxValue(id){
		var getEl = document.getElementById(id);
		if (getEl != null && getEl.checked){
			assignVal = getEl.value;
		}else{
			assignVal = '';
		}
		return assignVal;
	}
	
</script>
</head>

<body>

<div id="media-upload-header">
	<ul id="sidemenu">
		<li id="tab_general" class="current"><a href="javascript:;" class="mctab-to-js" data-id="general_settings"><?php _e('General Settings', 'wpimagehover');?></a></li>
		<?php if($wpimagehover_lite['social_display']):?>
			<li id="tab_social" ><a href="javascript:;" class="mctab-to-js" data-id="social_settings"><?php _e('Social Settings', 'wpimagehover');?></a></li>
		<?php endif;?>
	</ul>
</div>
<div id="dummy" style="display:none;">
	<input type="hidden" id="imgurl" />
	<input type="hidden" id="imgclass" />
	<input type="hidden" id="imgalt" />
	<input type="hidden" id="imgtitle" />
	<input type="hidden" id="imgwidth" />
	<input type="hidden" id="imgheight" />
</div>
<div id="wpimagehover-dialog" class="panel_wrapper wp-core-ui">
	
	<form method="post" action="" id="shortcodeform">
		<!-- General Settings Tab -->
		<div id="general_settings" class="panel current">
    		<table id="social" class="describe">
    			<tbody>
    				<tr>
						<th valign="top" scope="row" class="label">
							<label for="animation_hover">
							<span class="alignleft"><?php _e('Hover Animation','wpimagehover');?></span>
							</label>
						</th>
						<td class="field">
							<select id="animation_hover" name="animation_hover" class="widefat toselect2">
								<option value="fade" <?php if($wpimagehover_lite['animation_hover'] == "fade"){ echo 'selected="selected"'; }?>><?php _e('Fade','wpimagehover');?></option>
							</select>
						</td>
					</tr>
    				<tr>
						<th valign="top" scope="row" class="label">
							<label for="general_text">
							<span class="alignleft"><?php _e('Share Text Message','wpimagehover');?></span>
							</label>
						</th>
						<td class="field">
							<textarea id="general_text" name="general_text" class="widefat" placeholder="Insert Custom Share Message" style="height:150px;"></textarea>
						</td>
					</tr>
					<tr>
						<th valign="top" scope="row" class="label">
						</th>
						<td class="field">
							<input name="wpimagehover-insert" type="button" data-id="social_settings"class="mctab-to-js button button-primary" value="<?php _e('Next &raquo;', 'wpimagehover')?>" /> 
        					<input name="wpimagehover-insert" type="button" id="wpimagehover-insert" class="button button-primary" value="<?php _e('Update Image', 'wpimagehover')?>" onclick="addImage();" />   
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- End General Settings Tab -->

		<!-- Social Settings Tab -->
		<?php //if($wpimagehover_lite['social_display']):?>
		<div id="social_settings" class="panel">
    		<table id="social" class="describe">
    			<tbody>
    				<tr>
						<th valign="top" scope="row" class="label">
							<label for="social_style">
							<span class="alignleft"><?php _e('Style','wpimagehover');?></span>
							</label>
						</th>
						<td class="field">
							<select id="social_style" name="social_style" class="widefat toselect2">
								<option value="circle" <?php if($wpimagehover_lite['social_style'] == "circle"){ echo 'selected="selected"'; }?>><?php _e('Circle','wpimagehover');?></option>
								<option value="square" <?php if($wpimagehover_lite['social_style'] == "square"){ echo 'selected="selected"'; }?>><?php _e('Square','wpimagehover');?></option>
							</select>
						</td>
					</tr>
					<?php
					foreach ($wpimagehover_lite['socials'] as $key => $value) { 
						/**if($value == 1):**/ ?>
						<tr>
							<th valign="top" scope="row" class="label">
								<span class="alignleft"><input type="checkbox" value="1" name="show_<?php echo $key;?>" id="show_<?php echo $key;?>" <?php if($value == 1):?>checked="checked"<?php endif;?>/> <?php _e( ucfirst($key) ,'wpimagehover');?></span>
							</th>
							<td class="field">
								<input type="text" id="social_<?php echo $key;?>" name="social_<?php echo $key;?>" class="widefat" value="CURRENT"/>
							</td>
						</tr>
					<?php /**endif;**/ } ?>
					<tr>
						<th valign="top" scope="row" class="label">
						</th>
						<td class="field">
        					<input name="wpimagehover-insert" type="button" id="wpimagehover-insert" class="button button-primary" value="<?php _e('Update Image', 'wpimagehover')?>" onclick="addImage();" />   
						</td>
					</tr>
					
    			</tbody>
    		</table>
    		   
	    </div>
		<?php //endif;?>
		<!-- End Social Settings Tab -->
	</form>
</div>

</body>
</html>