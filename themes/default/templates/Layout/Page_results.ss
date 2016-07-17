<div class="container search-result">
	<% if $searchResults %>
		<div class="row results item-list padding-30">
			<% loop $searchResults %>
				<div class="search-result-item">
					<div class="item-title">$Title</div>
					<div class="item-content">$CutWords($Content)</div>
				</div>
			<% end_loop %>
		</div>
		
		<div class="row pagination">
			<% if $searchResults.MoreThanOnePage %>
				<% if $searchResults.NotLastPage %>
					<a class="next button black text-white text-centered extra-small" id="next" href="$searchResults.NextLink">Next</a>
				<% end_if %>
			<% end_if %>
		</div>
	<% else %>
	
	<% end_if %>
</div>