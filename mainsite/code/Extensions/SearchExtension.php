<?php use SaltedHerring\Debugger as Debugger;

class SearchExtension extends DataExtension {
	public function doSearch($data, $form, $request) {
		if (!SecurityToken::inst()->checkRequest($request)) {
			return $this->httpError(403);
		}
		
		$resultPack = $this->getResults($data = $data);
		$this->Title = _t('SearchForm.SearchResults', 'Search Results');
		$data = array(
            'Results'	=>	$resultPack['results'],
            'Query'		=>	$request->getVar('Search'),
            'Title'		=>	_t('SearchForm.SearchResults', 'Search Results')
        );
		
		$this->owner->searchResults = new PaginatedList($resultPack['results'], $this->owner->request);
		$this->owner->searchResults->setPageLength(1);
		
		return $this->owner->customise($data)->renderWith(array('Page_results', 'Page'));
	}
	
	public function NextResultPage() {
		// Are there any more pages?
		if (
			$this->owner->currentPage &&
			$this->owner->searchResults->CurrentPage() < $this->owner->searchResults->TotalPages()
		) {
			return 'page=' . ($this->owner->currentPage + 1);
		}

		// Default is page one.
		return 'page=1';
	}
	
	public function getResults($pageLength = null, $data = null) {
		return self::getResultsFromRequest();
	}
	
	public static function getResultsFromRequest() {
		
		$page_conditions = array();
		$work_conditions = array();
		$blog_conditions = array();
		$controller = Controller::curr();
		$keyword = $controller->request->getVar('Search');
		
		if ($keyword) {
			$page_conditions = array (
				'Title:PartialMatch'		=>	$keyword,
				'Content:PartialMatch'		=>	$keyword
			);
			
			$work_conditions = array (
				'Title:PartialMatch' 		=>	$keyword,
				'Content:PartialMatch'		=>	$keyword
			);
			
			$blog_conditions = array (
				'Title:PartialMatch'		=>	$keyword,
				'Content:PartialMatch'		=>	$keyword
			);
		}
		
		$page_results = Versioned::get_by_stage('Page', 'Live')->filterAny($page_conditions);
		$work_results = Work::get()->filterAny($work_conditions);
		$blog_results = BlogEntry::get()->filter($blog_conditions);
		
		
		$results = new ArrayList();
		$results->merge($page_results);
		$results->merge($work_results);
		$results->merge($blog_results);
		
		return array( 'results' => $results->sort(array('ID' => 'DESC')));
	}
}