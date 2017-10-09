<div class="main-nav">
    <nav class="nav">
        <ul class="level-root">
        <% loop Menu(1) %>
            <li<% if LinkOrCurrent == current || $LinkOrSection == section %> class="current"<% end_if %>>
                <a href="$Link" class="leading <% if LinkOrCurrent = current || $LinkOrSection = section %> current<% end_if %>">$MenuTitle.XML</a>
                <% if $ClassName.LowerCase == 'categorypage' %>
                <ul class="children level-2">
                <% loop $mySubCategories %>
                    <li><a href="{$Up.Link}{$Slag}" class="<% if $Top.isActive == $Slag %>active<% end_if %>">$Title</a></li>
                <% end_loop %>
                </ul>
                <% end_if %>
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
        <% end_loop %>
        </ul>
    </nav>
    <% include Social %>
</div>
