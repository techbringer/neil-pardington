<div class="$ViewportHeight jarallax"<% if $HeaderImage %> style="background-image: url($HeaderImage.URL);<% if $ViewportHeight == 'custom' && $ViewportCustomHeight %> height: {$ViewportCustomHeight}px;<% end_if %>"<% end_if %> data-jarallax='{"speed": 0.2}'>
	<% if $URLSegment == 'home' %>
		<span id="basetwo" class="as-block">basetwo</span>
		<span id="design" class="as-block">design</span>
	<% end_if %>
</div>
