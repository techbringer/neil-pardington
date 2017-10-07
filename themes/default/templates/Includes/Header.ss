<header id="header-new">
    <a id="logo" href="/" rel="start"><span class="hide">$SiteConfig.Title</span></a>
    <% if $URLSegment != 'home' %>
    <span id="weird-title">$Title</span>
    <% end_if %>
    <label id="btn-call-menu" for="trigger-menu">Menu</label>
    <input id="trigger-menu" type="checkbox" class="hide" />
    <% include Navigation %>
</header>
