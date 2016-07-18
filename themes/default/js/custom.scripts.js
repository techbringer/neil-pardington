jQuery(document).ready(function($) {
    /**
     * Parallax blocks:
     * ----------------
     * For each parallax block, get the backgound image & apply as
     * a parallax layer.
     * */
    $('.parallax').each(function() {
        var url			=	$(this).data('image-src');
		
		if ($(this).hasClass('full')) {
			$(this).height($(window).height());
		}

        if ($('body').is('.mobile')) {
            $(this).css({
				'background-image': 'url(' + url + ')',
				'background-size': 'cover'
			});
        } else {
            $(this).parallax({imageSrc: url});
        }
    });
	
	/**
     * Menu works:
     * ----------------
     * ditto
     * */
	
	var former_current		=	$('.nav li a.current:eq(0)'),
		current_active		=	null,
		hide_ul				=	function(ul) {
									ul.parent().find('a:eq(0)').removeClass('current');
									if (current_active.is(ul)) {
										current_active = false;
									}
									
									TweenMax.to(ul, 0.3, {opacity: 0, height: 0, onComplete: function() {
										ul.hide();
										ul.removeAttr('style');
										ul.unbind('mouseleave');
									}});
								};
	$('#logo').mouseenter(function(e) {
        if (current_active) {
			hide_ul(current_active);
		}
    });
	
	$('#header').mouseleave(function(e) {
		if (current_active) {
			hide_ul(current_active);
		}
	});
	
    $('.nav li:not(".nav li li")').mouseenter(function(e) {
		var ul 				=	$(this).find('ul').length > 0 ? $(this).find('ul:eq(0)') : null;
			ul_height		=	0;
		
		if (!$(this).find('a:eq(0)').is(former_current)) {
			former_current.removeClass('current');
		}
		
		if (current_active && !current_active.is(ul)) {
			hide_ul(current_active);
		}
		if (ul && !ul.is(':visible')) {
			
			$(this).find('a:eq(0)').addClass('current');
			
			current_active	=	ul;
			
			ul.show();
			ul_height = ul.outerHeight();
	        TweenMax.to(ul, 0, {opacity: 0, height: 0, onComplete: function() {
				TweenMax.to(ul, 0.3, {opacity: 1, height: ul_height});
			}});
			
			ul.mouseleave(function(e) {
				hide_ul(ul);
			});
		}
    }).mouseleave(function(e) {
        if (!current_active) {
			former_current.addClass('current');
		}
    });
	
	/**
     * Search input effect
     * ----------------
     * ...
     * */
	var label				=	$('#GeneralSearchForm_GeneralSearchForm label'),
		input				=	$('#GeneralSearchForm_GeneralSearchForm_Search').css('opacity', 0),
		scrollTop			=	0;
		
    input.focus(function(e) {
		TweenMax.to(input, 0, {opacity: 0, onComplete: function() {
			TweenMax.to(input, 0.2, {opacity: 1, delay: 0.15});
		}});
		TweenMax.to(label, 0.2, {scale: 10, opacity: 0, onComplete:function(){ label.hide(); }});
	}).blur(function(e) {
		TweenMax.to(input, 0.1, {opacity: 0, onComplete: function(){
			//input.val('');
		}});
        TweenMax.to(label.css('display', 'block'), 0.2, {scale: 1, opacity: 1});
    });
	
	$('#btn-search').click(function(e) {
        e.preventDefault();
		scrollTop = $(window).scrollTop();
		$('html').addClass('locked');
		$(window).resize();
		TweenMax.to($('#search-wrapper').show(), 0, {opacity: 0, onComplete: function() {
			TweenMax.to($('#search-wrapper'), 0.3, {opacity: 1});
			$(window).keydown(function(e) {
                if (e.keyCode == 27) {
					$('#btn-close').click();
				} else {
					if (e.keyCode != 17 && e.keyCode != 18 && e.keyCode != 13) {
						if (!input.is(':focus')) {
							input.val('');
							input.focus();
						}
					}
				}
            });
		}});
    });
	
	$('#btn-close').click(function(e) {
        e.preventDefault();
		$('html').removeClass('locked');
		$(window).resize().scrollTop(scrollTop).unbind('keydown');
		TweenMax.to($('#search-wrapper'), 0.3, {opacity: 0, onComplete: function() {
			$('#search-wrapper').hide();
			//input.val('');
		}});
    });
	
	
	/**
     * hide down arrow
     * ----------------
     * ...
     * */
	var arrow = $('#btn-read-on').length == 1 ? $('#btn-read-on') : null;
	if (arrow) {
		var t = null;
		$(window).scroll(function(e) {
			if ($(window).scrollTop() > $('#footer').outerHeight()) {
				
				if (t) { t.kill(); t = null; }
				t = TweenMax.to(arrow, 1, {bottom: 100, opacity: 0, onComplete:function() {
					arrow.hide();
					t = null;
				}});
			} else {
				if (t) { t.kill(); t = null; }
				arrow.show();
				t = TweenMax.to(arrow, 1, {bottom: 72, opacity: 1, onComplete:function() {
					arrow.removeAttr('style');
					t = null;
				}});
			}
		});
		arrow.click(function(e) {
			e.preventDefault();
			$.scrollTo($('#content-area'), 500);
		});
	}
	
	/**
     * remove marked elements
     * ----------------
     * ...
     * */
	$('.js-to-hide').remove();
	
	/**
     * mobile menu
     * ----------------
     * ...
     * */
	var timeline_1			=	new TimelineMax(),
		timeline_2			=	new TimelineMax(),
		timeline_3			=	new TimelineMax(),
		burger				=	$('#btn-mobile'),
		bar_1				=	burger.find('.first'),
		bar_2				=	burger.find('.second'),
		bar_3				=	burger.find('.third');
	
	
	timeline_1.pause();
	timeline_1.to(bar_1, 0.3, {'margin-top': 0});
	timeline_1.to(bar_1, 0.3, {rotation: -45, width: '60%', left: '20%', height: 2});
	
	timeline_2.pause();
	timeline_2.to(bar_2, 0.3, {opacity: 0});
	timeline_2.to(bar_2, 0.3, {});
	
	timeline_3.pause();
	timeline_3.to(bar_3, 0.3, {'margin-top': 0});
	timeline_3.to(bar_3, 0.3, {rotation: 45, width: '60%', left: '20%', height: 2});
	
	
	$(burger).click(function(e) {
        e.preventDefault();
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			timeline_1.reverse();
			timeline_2.reverse();
			timeline_3.reverse();
		} else {
			$(this).addClass('active');
			timeline_1.play();
			timeline_2.play();
			timeline_3.play();
		}
    });
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});