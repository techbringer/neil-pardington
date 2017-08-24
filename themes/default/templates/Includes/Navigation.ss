<nav class="nav">
    <ul>
        <li><a class="<% if $URLSegment = 'home' %>current<% end_if %>" href="/" id="logo" rel="start" class="uppercase">Base Two</a></li>
		<% loop Menu(1) %>
			<% if $isPublished %>
                <li>
                    <a href="$Link" class="<% if LinkOrCurrent = current || $LinkOrSection = section %>current<% end_if %>">$MenuTitle.XML</a>
					<% if Children %>
                        <ul class="children level-2">
							<% loop Children %>

                                <li>
                                    <a href="$Link" class="<% if LinkOrCurrent = current %>current<% end_if %>">$MenuTitle.XML</a>
									<% if $ClassName.LowerCase == 'categorypage' %>
                                        <ul class="children level-3">
											<% loop $mySubCategories %>
                                                <li><a href="{$Up.Link}{$Slag}" class="<% if $Top.isActive == $Slag %>active<% end_if %>">$Title</a></li>
											<% end_loop %>
                                        </ul>
									<% end_if %>
                                </li>
							<% end_loop %>
                        </ul>
					<% end_if %>
                </li>
			<% end_if %>
		<% end_loop %>
    </ul>
</nav>
