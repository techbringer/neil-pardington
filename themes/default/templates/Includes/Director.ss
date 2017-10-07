<div class="director">
    <div class="is-flex align-vertical-bottom">
        <div class="director__portrait">
            <% if $Portrait %>
                $Portrait.FillMax(186,232)
            <% else %>
                <img src="http://via.placeholder.com/186x232" width="186" height="232" alt="$Title" />
            <% end_if %>
        </div>
        <div class="director__details">
            $Title<br />
            <strong>$Position</strong><br />
            <strong>Phone:</strong> $Phone<br />
            <strong>Email:</strong> $Email
        </div>
    </div>
</div>
