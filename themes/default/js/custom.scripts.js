jQuery(document).ready(function($) {
    /**
     * Parallax blocks:
     * ----------------
     * For each parallax block, get the backgound image & apply as
     * a parallax layer.
     * */
    $('.parallax').each(function() {
        var url = $(this).data('image-src');
		if ($(this).hasClass('full')) {
			$(this).height($(window).height());
		}

        if ($('body').is('.mobile')) {
            $(this).css({'background-image': 'url(' + url + ')'});
        } else {
            $(this).parallax({imageSrc: url});
        }
    });
	
	
});