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
	<body class="page-$URLSegment<% if $isMobile %> mobile<% end_if %> page-type-$BodyClass.LowerCase">
		<% include Header %>
		
		<main id="main">
			<% if $HeaderImage && $Content %><div class="section"><% end_if %>
				<% if $HeaderImage %>
					<% include Parallax %>
				<% end_if %>
			<% if $HeaderImage && $Content %></div><% end_if %>
			<% if $Form || $Content || not $HideTitle %>
			<div id="content-area" class="container">
				<h1 id="page-title" class="<% if $HideTitle %>hide<% end_if %>">$Title</h1>
				$Form
				$Content
			</div>
			<% end_if %>
			$Layout			
		</main>
		
		<% include Footer %>
	</body>
</html>