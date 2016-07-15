<div class="container">
	<% loop $Blogs %>
		<% if odd %><div class="row"><% end_if %>
		<a href="{$Top.Link}{$Slag}" class="blog-entry">
			<div class="blog-thumb">
				<% with $HeaderImage.FillMax(500, 300) %>
					<img src="$URL" width="$Width" height="$Height" />
				<% end_with %>
				<h3 class="blog-entry-title">$Title</h3>
			</div>
			<div class="blog-entry-misc">
				<div class="float-left blog-entry-tags">
					<% loop $Tags %>
						$Title <% if not Last %>| <% end_if %>
					<% end_loop %>
				</div>
				<div class="float-right blog-entry-date">$DateCreated</div>
			</div>
		</a>
		<% if even %></div><% else %><% if last %></div><% end_if %><% end_if %>
	<% end_loop %>
</div>