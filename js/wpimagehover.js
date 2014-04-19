/**
*
* Wordpress Image Hover Showcase Plugin
* URL: http://www.codecanyon.net/user/phpbits
* Version: 1.0
* Author: phpbits
* Author URL: http://www.codecanyon.net/user/phpbits
*
*/

// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var construct_wpimagehover = {
		init: function( options, elem ) {
			var self = this;

			self.elem = elem;
			self.$elem = $( elem );

			self.options = $.extend( {}, $.fn.wpimagehover.options, options );

			self.display();
		},
		display: function(){
			var self = this;
			var getSocials = self.buildSocials();
			var getButton = '';
			var getTitle = '';
			var newClass = '';
			var getW = self.$elem.width();
			var getH = self.$elem.height();
			var unique = Math.floor( Math.random()*99999 );
			var getData = self.$elem.data();
			
			//remove title option, Upgrade to Pro version for this cool feature

			if(self.options.noSocials){
				getSocials = '';
			}

			self.$elem.wrapAll(function(){
				self.$elem.removeClass('wpimagehover');
				classes = self.$elem.attr('class');
				self.$elem.removeClass();
				if(getW < 320){
					newClass = 'wpimagehover-small';
				}else{
					newClass = '';
				}

				if('sstyle' in getData){
					classes += ' wpimagehover-socials-' + getData.sstyle;
				}else{
					classes += ' wpimagehover-socials-' + self.options.socialStyle;
				}

				// if( self.options.socialStyle == 'circle'){
				// 	classes += ' wpimagehover-socials-circle';
				// }

				//set animation class
				if('animation' in getData){
					classes += ' wpimagehover-anim-' + getData.animation;
				}else{
					classes += ' wpimagehover-anim-' + self.options.animation;
				}

				return '<div class="wpimagehover-wrapper '+ classes +' '+ newClass +'" id="wpimagehover-'+ unique +'"></div>';
			});
			

			$('#wpimagehover-'+ unique + '.wpimagehover-wrapper').prepend('<div class="wpimagehover-overlay"></div>');
			//get socials

			var caption = '<div class="wpimagehover-caption">'+ getTitle + getSocials + getButton +'</div>';
			$('#wpimagehover-'+ unique + '.wpimagehover-wrapper').append( caption );

			//position to middle
			el = '#wpimagehover-'+ unique + ' .wpimagehover-caption';
			$('#wpimagehover-'+ unique + ' .wpimagehover-socials').css({ 'max-width' : getW + 'px' });
			elH = $( el ).innerHeight();

			//fix for overflow on height
			//console.log(elH + '-'+ unique +'-' + getH);
			$( el ).css({ 'margin-top' : '-' + elH/2 + 'px', 'top' : '50%', 'bottom' : '50%' });
			$('#wpimagehover-'+ unique + ' .wpimagehover-overlay').css({ width :  getW + 'px', 'margin-left' : '-'+ getW / 2  +'px'});
			
			//on resize function to rebuild overlay
			self.onResize(unique);
		},
		buildSocials: function(){
			var self = this;
			var classes = 'wpimagehover-socials wpimagehover-socials-' + self.options.socialType;
			var socials = '<div class="'+ classes +'">';
				getData = self.$elem.data();
			var fburl = '';
			var tweeturl = '';
			var linkedinurl = '';
			var pinurl = '';
			var plusurl = '';
			var diggurl = '';
			var deliciousurl = '';
			var stumbleuponurl = '';
				$.each(getData, function(k,v){
					switch( k ){
						case 'fburl' :
							fburl += '<a href="'+ v +'" class="wpimagehover-facebook"';
							fburl += self.shareData(k);
							fburl += '><span class="wpimagehover-icon wpimagehover-icon-facebook"></span></a>';
						break;
						case 'tweeturl' :
							tweeturl += '<a href="'+ v +'" class="wpimagehover-twitter"';
							tweeturl += self.shareData(k);
							tweeturl += '><span class="wpimagehover-icon wpimagehover-icon-twitter"></span></a>';
						break;
						case 'linkedinurl' :
							linkedinurl += '<a href="'+ v +'" class="wpimagehover-linkedin"';
							linkedinurl += self.shareData(k);
							linkedinurl += '><span class="wpimagehover-icon wpimagehover-icon-linkedin"></span></a>';
						break;
						case 'pinurl' :
							pinurl += '<a href="'+ v +'" class="wpimagehover-pinterest"';
							pinurl += self.shareData(k);
							pinurl += ' data-title="'+ self.$elem.attr('src') +'"';
							pinurl += '><span class="wpimagehover-icon wpimagehover-icon-pinterest"></span></a>';
						break;
						case 'plusurl' :
							plusurl += '<a href="'+ v +'" class="wpimagehover-googleplus"';
							plusurl += self.shareData(k);
							plusurl += '><span class="wpimagehover-icon wpimagehover-icon-googleplus"></span></a>';
						break;
						case 'diggurl' :
							diggurl += '<a href="'+ v +'" class="wpimagehover-digg"';
							diggurl += self.shareData(k);
							diggurl += '><span class="wpimagehover-icon wpimagehover-icon-digg"></span></a>';
						break;
						case 'deliciousurl' :
							deliciousurl += '<a href="'+ v +'" class="wpimagehover-delicious"';
							deliciousurl += self.shareData(k);
							deliciousurl += '><span class="wpimagehover-icon wpimagehover-icon-delicious"></span></a>';
						break;
						case 'stumbleuponurl' :
							stumbleuponurl += '<a href="'+ v +'" class="wpimagehover-stumbleupon"';
							stumbleuponurl += self.shareData(k);
							stumbleuponurl += '><span class="wpimagehover-icon wpimagehover-icon-stumbleupon"></span></a>';
						break;
						default:
						break;
					}
				});
			socials += fburl;
			socials += tweeturl;
			socials += linkedinurl;
			socials += pinurl;
			socials += plusurl;
			socials += diggurl;
			socials += deliciousurl;
			socials += stumbleuponurl;
			return socials += '</div>';
		},
		shareData: function(type){
			var self = this;
			var getData = self.$elem.data();
			var typeValue = self.$elem.data(type);
			var ret = '';
			if('sharetxt' in getData){
				ret += ' data-text="'+ getData.sharetxt +'"';
			}
			if(typeValue == 'CURRENT'){
				ret += ' data-url="'+ document.URL +'"';
			}else{
				ret += ' data-url="'+ typeValue +'"';
			}
			return ret;
		},
		onResize: function(unique){
			var self = this;
			$(window).resize(function(){
				var getW = self.$elem.width();
				$('#wpimagehover-'+ unique + ' .wpimagehover-overlay').css({ width :  getW + 'px', 'margin-left' : '-'+ getW / 2  +'px'});
			});
		}
	};

	$.fn.wpimagehover = function( options ) {
		return this.each(function() {
			var wpimagehover = Object.create( construct_wpimagehover );
			
			wpimagehover.init( options, this );

			$.data( this, 'wpimagehover', wpimagehover );
		});
	};

	$.fn.wpimagehover.options = {
		animation : 'slideup',
		noSocials : false,
		noButton : true,
		socialStyle : 'default',
		socialType : 'colored'
	};

})( jQuery, window, document );