<div class="parallax $ViewportHeight" data-parallax="scroll" <% if $HeaderImage %>data-image-src="$HeaderImage.URL"<% end_if %><% if $ViewportHeight == 'custom' && $ViewportCustomHeight %>style="height: {$ViewportCustomHeight}px"<% end_if %>>
	<% if $URLSegment == 'home' %>
		<span id="basetwo" class="as-block">basetwo</span>
		<span id="design" class="as-block">design</span>
	<% end_if %>
</div>