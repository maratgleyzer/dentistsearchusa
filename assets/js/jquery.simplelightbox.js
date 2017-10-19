jQuery.fn.simpleLightbox = function(_options){
	// defaults options		_global_lightbox = null;	_global_fader = null;	_global_scroll = null;	
	var _options = jQuery.extend({
		lightboxContentBlock: '.lightbox',
		faderOpacity: 0.8,
		faderBackground: '#000000',
		closeLink:'a.close-btn',
		href:true,
		onClick: null
	},_options);

	return this.each(function(i, _this){
		var _this = jQuery(_this);
		if (!_options.href)
			_this.lightboxContentBlock = _options.lightboxContentBlock;
		else _this.lightboxContentBlock = _this.attr('href');
		if (_this.lightboxContentBlock != '' && _this.lightboxContentBlock.length > 1) {
			_this.faderOpacity = _options.faderOpacity;
			_this.faderBackground = _options.faderBackground;
			_this.closeLink = _options.closeLink;
			var _fader;
			var _lightbox = $(_this.lightboxContentBlock);				_global_lightbox = _lightbox; //added
			if (!jQuery('div.lightbox-fader').length)
				_fader = $('body').append('<div class="lightbox-fader"></div>');				_global_fader = _fader; //added
			
			_fader = jQuery('div.lightbox-fader');			_global_fader = _fader; //added
			_lightbox.css({
				'zIndex':999
			});
			_fader.css({
				opacity:_this.faderOpacity,
				backgroundColor:_this.faderBackground,
				display:'none',
				position:'absolute',
				top:0,
				left:0,
				zIndex:998,
				textIndent: -9999
			}).text('$nbsp');
			_lightbox.shownFlag = false;
			_this.click(function(){
				if (jQuery.isFunction(_options.onClick)) {
					_options.onClick.apply(_this);
				}
				_lightbox.shownFlag = true;
				_lightbox.hide();
				jQuery.fn.simpleLightbox.positionLightbox(_lightbox);
				_fader.fadeIn(300, function(){
					_lightbox.fadeIn(400);
					jQuery.fn.simpleLightbox.positionLightbox(_lightbox);
				});
				return false;
			});
			jQuery(_this.closeLink).click(function(){
				_lightbox.fadeOut(400, function(){
					_fader.fadeOut(300);
					_scroll = false;
				});
				return false;
			});
			_fader.click(function(){
				_lightbox.fadeOut(400, function(){
					_fader.fadeOut(300);
				});
				return false;
			});
			var _scroll = false;
			jQuery.fn.simpleLightbox.positionLightbox = function (_lbox) {
				if(!_lbox.shownFlag) return false;
				var _height = 0;
				var _width = 0;
				var _minWidth = $('body > div:eq(0)').outerWidth();
				if (window.innerHeight) {
					_height = window.innerHeight;
					_width = window.innerWidth;
				} else {
					_height = document.documentElement.clientHeight;
					_width = document.documentElement.clientWidth;
				}
				var _thisHeight = _lbox.outerHeight();
				var _page = $('body');
				if (_lbox.length) {
					if (_width < _minWidth) {_fader.css('width',_minWidth);} else {_fader.css('width','100%');}
					if (_height > _page.innerHeight()) _fader.css('height',_height); else _fader.css('height',_page.innerHeight());
					if (_height > _thisHeight) {
						if ($.browser.msie && $.browser.version < 7) {
							_lbox.css({
								position:'absolute',
								top: (document.documentElement.scrollTop + (_height - _thisHeight) / 2)+"px"
							});
						} else {
							_lbox.css({
								position:'fixed',
								top: ((_height - _lbox.outerHeight()) / 2)+"px"
							});
						}
					}
					else {
						var _fh = parseInt(_fader.css('height'));
						if (!_scroll) {
						if (_fh - _thisHeight > parseInt($(document).scrollTop())) {
								_fh = parseInt($(document).scrollTop())
								_scroll = _fh;								_global_scroll = _scroll;	//added
							} else {
								_scroll = _fh - _thisHeight;								_global_scroll = _scroll; //added
							}
						}
						_lbox.css({
							position:'absolute',
							top: _scroll
						});
					}
					if (_width > _lbox.outerWidth()) _lbox.css({left:((_width - _lbox.outerWidth()) / 2 + 10) + "px"});
					else _lbox.css({position:'absolute',left: 0});
				}
			}
			
			jQuery(window).resize(function(){
				if (_lightbox.is(':visible'))
					jQuery.fn.simpleLightbox.positionLightbox(_lightbox);
			});
			jQuery(window).scroll(function(){
				if (_lightbox.is(':visible'))
					jQuery.fn.simpleLightbox.positionLightbox(_lightbox);
			});
			
			jQuery.fn.simpleLightbox.positionLightbox(_lightbox);
				$(document).keydown(function (e) {
				if (!e) evt = window.event;
				if (e.keyCode == 27) {
					_lightbox.fadeOut(400, function(){
						_fader.fadeOut(300);
					});
				}
			});
		}
	});
}

$(function(){
	$('a.open-popup').simpleLightbox({
		faderOpacity: 0.7,
		faderBackground: '#fff',
		closeLink:'a.close'
	});
});