<%-- <% if $CategoryHeader %>
    <section id="subcategory-section" class="work">
        <% include Parallax HeaderImage=$CategoryHeader %>
        <div class="container">
            <div class="work-title">
                <header class="work-title"><p><strong>$CategoryTitle</strong></p><h2>Introduction</h2></header>
            </div>
            <div class="work-content">
                $CategoryIntro
            </div>
        </div>
    </section>
<% end_if %>
<% loop $Works %>
    $Me
<% end_loop %> --%>
<div class="works ajax-content" data-endpoint="/api/v/1/works/$Endpoint">
    <div class="ajax-list"></div>
</div>
