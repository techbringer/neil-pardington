<div class="container search-result">
	<% if $searchResults %>
		<div class="row results item-list">
			<% loop $searchResults %>
				<a class="search-result-item" href="$URL">
					<h2 class="item-title">$Title</h2>
					<div class="item-content"><span class="as-block margin-bottom-half-em">$DateCreated</span> $CutWords($Content, $Up.Query)</div>
				</a>
			<% end_loop %>
		</div>
		
		<div class="row pagination text-right">
			<% if $searchResults.MoreThanOnePage %>
				<% if $searchResults.NotFirstPage %>
					<a class="next button black text-white text-centered extra-small" id="prev" href="$searchResults.PrevLink">Prev</a>
				<% end_if %>
				<% if $searchResults.NotFirstPage && $searchResults.NotLastPage %> | <% end_if %>
				<% if $searchResults.NotLastPage %>
					<a class="next button black text-white text-centered extra-small" id="next" href="$searchResults.NextLink">Next</a>
				<% end_if %>
			<% end_if %>
		</div>
	<% else %>
		<div class="row results item-list">
			<% if $error %>
			$error
			<% else %>
			- no result -
			<% end_if %>
		</div>
	<% end_if %>
</div>