(function($) {
    $.fn.afetch = function(cbf)
    {
        var self            =   this,
            me              =   $(this),
            callback        =   cbf,
            nextPageURL     =   null,
            pulling         =   false,
            fetch           =   function(endpoint, listTo)
                                {
                                    nextPageURL         =   null;
                                    $.get(
                                        endpoint,
                                        function(data)
                                        {
                                            pulling     =   false;
                                            nextPageURL =   data.pagination.href;
                                            if (cbf) {
                                                cbf(data, listTo);
                                            }
                                        }
                                    );
                                };

        this.refresh        =   function()
        {
            me.each(function(i, el)
            {
                var me          =   $(this),
                    endpoint    =   me.data('endpoint'),
                    listTo      =   me.find('.ajax-list').addClass('ajax-processed');

                fetch(endpoint, listTo);
                // navTo.unbind('click').click(function(e)
                // {
                //     e.preventDefault();
                //     var endpoint    =   $(this).attr('href');
                //     if (endpoint.length > 0) {
                //         fetch(endpoint, listTo);
                //     }
                // });

                $(window).scroll(function(e)
                {
                    if (listTo.children().last().visible(true) && !pulling && nextPageURL) {
                        pulling =   true;
                        fetch(nextPageURL, listTo);
                    }
                });
            });
        };

        this.refresh();

        return self;
    };
})(jQuery);
