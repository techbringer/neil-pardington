<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<% base_tag %>
		$MetaTags(true)
		<% include OG %>
		<meta name="viewport" content="width=device-width">

		$getCSS
		
		<script src="$ThemeDir/js/lib/modernizr.min.js"></script>
		
		<% include GA %>
	</head>
	<body class="page-$URLSegment<% if $isMobile %> mobile<% end_if %> page-type-$BodyClass.LowerCase<% if $isBlogEntry %> single-blog-entry-page<% end_if %>">
		<% include Header %>
		
		<main id="main">
			<% if $HeaderImage && $Content %><div class="section"><% end_if %>
				<% if $HeaderImage %>
					<% include Parallax %>
				<% end_if %>
			<% if $HeaderImage && $Content %></div><% end_if %>
			<% if $Form || $Content || not $HideTitle %>
			<div id="content-area" class="container">
				<% if $isBlogEntry %>
					<div class="title">
						<span class="row as-block sub-title">Blog</span>
						<h1 id="page-title">$Title</h1>
						<div class="row blog-tags">
							<% loop $Tags %>
								<a href="/search/GeneralSearchForm?tag={$Slag}&SecurityID={$SecurityID}">$Title</a> <% if not Last %>| <% end_if %>
							<% end_loop %>
						</div>
						<div class="row blog-created">$DateCreated</div>
					</div>
				<% else %>
					<% if $BodyClass.LowerCase == 'contact-page' %>
						<div class="title">
							<h1 id="page-title">$Title<% if $SubTitle %> <span class="sub-title as-block">$SubTitle</span><% end_if %></h1>
							<div class="address">$Address</div>
						</div>
					<% else %>
						<h1 id="page-title" class="title<% if $HideTitle %> hide<% end_if %>">$Title<% if $SubTitle %> <span class="sub-title as-block">$SubTitle</span><% end_if %></h1>						
					<% end_if %>
				<% end_if %>
				<div class="content">
					$Content
					$Form
					<% if $Form %>
						<script src='https://www.google.com/recaptcha/api.js'></script>
					<% end_if %>
				</div>
			</div>
			<% else %>
				<% if $BodyClass.LowerCase == 'category-page' || $BodyClass.LowerCase == 'works-page' %>
					<h1 id="page-title" class="title<% if $HideTitle %> hide<% end_if %>">$Title<% if $SubTitle %> <span class="sub-title as-block">$SubTitle</span><% end_if %></h1>
				<% end_if %>
			<% end_if %>
			$Layout			
		</main>
		
		<% include Footer %>
	</body>
</html>