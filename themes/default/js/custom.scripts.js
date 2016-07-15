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
            $(this).css({'background-image': 'url(' + url + ')'});
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
	
});