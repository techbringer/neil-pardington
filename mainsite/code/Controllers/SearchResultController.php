<?php
/**
 * @file SearchResultController.php
 *
 * Signup controller.
 * */
class SearchResultController extends Page_Controller {

	private static $url_handlers = array(
		''	=>	'index'
	);
	
	private static $allowed_actions = array(
		'index',
		'GeneralSearchForm'
	);
	
	private static $extensions = array(
		'SearchExtension',
	);
	
	public function index($request) {
		/*$keywords = $request->getVars('Search');
		$honeyPot = $request->getVars('Email');
		
		if ($honeyPot) { return $this->httpError(400); }
		if (!SecurityToken::inst()->checkRequest($request)) {
			return $this->httpError(403);
		}*/
		//return $this->renderWith(array('Page_results', 'Page'));
		return $this->redirectBack();
	}
	
	public function GeneralSearchForm() {
		return new GeneralSearchForm($this, new FieldList(
			new FormAction('doSearch', 'GO')
		));
	}
	
	public function Title() {
		return 'Search Results';
	}
}