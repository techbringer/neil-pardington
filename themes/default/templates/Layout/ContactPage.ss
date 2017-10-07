<%-- <section class="container guide-gmap">
	<header class="row padding-30"><h2>Where we are</h2></header>
	<div class="title">
		$FindUsGuide
	</div>
	<div class="content">
		<iframe seamless class="gmap-frame" frameborder="0" style="border: none;" src="https://apps.base2.co.nz/apps/gmap?lat={$Latitude}&amp;lng={$Longitude}&amp;marker_title={$MarkerTitle}&amp;marker_content={$MarkerContent}"></iframe>
	</div>
</section> --%>
<% if $Directors %>
<section class="section-directors">
    <div class="container">
        <div class="directors">
        <% loop $Directors %>
            $Me
        <% end_loop %>
        </div>
    </div>
</section>
<% end_if %>

<section class="section-locations">
    <div class="container">
        <h2 class="locations-title">Address</h2>
        <div class="locations is-flex">
            <div class="location postal column">
                <h3 class="location__title">Postal</h3>
                $Postal
            </div>
            <div class="location physical column">
                <h3 class="location__title">Physical</h3>
                $Physical
            </div>
        </div>
    </div>
</section>

<section class="contact-us-form">
    <div class="container">
        <h2 class="contact-us-form__title">
            Technical Support
        </h2>
        <div class="contact-us-form__content">
            $FindUsGuide
        </div>
        <div class="contact-us-form__form">
            $Form
            <% if $Form %>
                <script src='https://www.google.com/recaptcha/api.js'></script>
            <% end_if %>
        </div>
    </div>
</section>
