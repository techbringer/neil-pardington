<nav id="main_nav" class="grid_9">
	<ul>
		<% loop Menu(1) %>
			<li>
				<a href="$Link" class="<% if LinkOrCurrent = current || $LinkOrSection = section %>current<% end_if %>">$MenuTitle.XML</a>
				<% if Children %>
				<ul class="children level-2">
					<% loop Children %>
						<li><a href="$Link" class="<% if LinkOrCurrent = current %>current<% end_if %>">$MenuTitle.XML</a></li>
						<% if $ClassName.LowerCase == 'categorypage' %>
						<ul class="children level-3">
						<% loop $SubCategories %>
							<li><a href="{$Up.Link}{$Slag}" class="">$Title</a></li>
						<% end_loop %>
						</ul>
						<% end_if %>
					<% end_loop %>
				</ul>
				<% end_if %>
			</li>
		<% end_loop %>
	</ul>
</nav>
