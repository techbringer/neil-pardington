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