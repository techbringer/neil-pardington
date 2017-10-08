Handlebars.registerHelper('ifEqual', function(a, b, options) {
    if(a === b) {
        return options.fn(this);
    }
    return options.inverse(this);
});

var WorkTemplate    =   '<section id="work-{{Slug}}" class="work">\
                            <div class="{{ViewportHeight}} jarallax"{{#if HeaderImage}} style="background-image: url({{HeaderImage}});{{#ifEqual ViewportHeight "custom"}}{{#if ViewportCustomHeight}} height: {{ViewportCustomHeight}}px;{{/if}}{{/ifEqual}}{{/if}}"></div>\
                            <header class="work-title"><h2 class="container">{{Title}}</h2></header>\
                            <div class="container work-content">\
                                <div class="work-content">\
                                    {{{Content}}}\
                                </div>\
                            </div>\
                        </section>',
    Work            =   function(data)
    {
        this.tpl    =   Handlebars.compile(WorkTemplate);
        this.html   =   $($.trim(this.tpl(data)));

        return this.html;
    };
