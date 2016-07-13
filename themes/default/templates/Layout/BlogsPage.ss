<div class="container">
	<% loop $Blogs %>
		<a href="{$Top.Link}{$Slag}" class="blog-entry grid_6">
			<div class="blog-thumb">
				<% with $HeaderImage.FillMax(480, 280) %>
					<img src="$URL" width="$Width" height="$Height" />
				<% end_with %>
				<h3 class="blog-entry-title">$Title</h3>
			</div>
			<div class="blog-entry-mis row">
				<div class="grid_3">
					<% loop $Tags %>
						$Title <% if not Last %>| <% end_if %>
					<% end_loop %>
				</div>
				<div class="grid_2 float-right">$Created.Date</div>
			</div>
		</a>
	<% end_loop %>
</div>