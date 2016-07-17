<?php
/**
 * General search form
 * */
class GeneralSearchForm extends SearchForm {
	
	public function __construct($controller, $actions = null) {
		
		parent::__construct($controller, 'GeneralSearchForm', null, $actions);
		
		/**
		 * Set placeholder on keywords.
		 * */
		if (!is_null($this->Fields())) {
			$keywords = $this->Fields()->fieldByName('Search');
			
			if ($keywords) {
				// Add the query to the value of the search field.
				$keywords->setAttribute('autocomplete', 'off');
				if ($this->getSearchQuery()) {
					$keywords->setValue($this->getSearchQuery());
				}
			}			
		}
		
		/**
		 * Change the submit input field to button.
		 * */
		if (!is_null($this->Actions())) {
			$action = $this->Actions()->fieldByName('action_doSearch');
			if ($action) {
				$action->addExtraClass('hide');
			}
		}
		
		$this->setFormAction(Controller::join_links(BASE_URL, 'search', 'GeneralSearchForm'));
		$this->setFormMethod('GET');
		$this->setStrictFormMethodCheck(true);
		$this->enableSecurityToken();
	}
	
}
