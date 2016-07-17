<?php use SaltedHerring\Debugger as Debugger;

class SearchExtension extends DataExtension {
	
	private static $IGNORES = array('CategoryPage', 'WorksPage', 'ErrorPage');
	
	public function doSearch($data, $form, $request) {
		if (!SecurityToken::inst()->checkRequest($request)) {
			return $this->httpError(403);
		}
		
		$resultPack = $this->getResults($data = $data);
		
		if (empty($resultPack['results'])) {
			return $this->owner->customise($resultPack)->renderWith(array('Page_results', 'Page'));
		}
		
		$this->Title = _t('SearchForm.SearchResults', 'Search Results');
		$data = array(
            'Results'	=>	$resultPack['results'],
            'Query'		=>	$request->getVar('Search'),
            'Title'		=>	_t('SearchForm.SearchResults', 'Search Results')
        );
		
		$this->owner->searchResults = new PaginatedList($resultPack['results'], $this->owner->request);
		$this->owner->searchResults->setPageLength(20);
		
		return $this->owner->customise($data)->renderWith(array('Page_results', 'Page'));
	}
	
	public function PrevResultPage() {
		// Are there any more pages?
		if (
			$this->owner->currentPage &&
			$this->owner->searchResults->CurrentPage() > 1
		) {
			return 'page=' . ($this->owner->currentPage - 1);
		}

		// Default is page one.
		return 'page=1';
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
		$tag_conditions = array();
		$controller = Controller::curr();
		$keyword = $controller->request->getVar('Search');
		$tag = $controller->request->getVar('tag');
		
		if ($keyword) {
			
			if (strlen($keyword) < 3) {
				return array(
						'results'			=>	false,
						'error'				=>	'search term is too short'
					);
			}
			
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
			
			$page_results = Versioned::get_by_stage('Page', 'Live')->filterAny($page_conditions);
			$work_results = Work::get()->filterAny($work_conditions);
			$blog_results = BlogEntry::get()->filter($blog_conditions);
			
			$results = new ArrayList();
			$results->merge($page_results);
			
		} elseif ($tag) {
			$results = new ArrayList();
			$tag_obj = Tag::get()->filter(array('Slag' => $tag));
			$work_results = array();
			$blog_results = array();
			
			if ($tag_obj->count() > 0) {
				$work_results = $tag_obj->first()->Works();
				$blog_results = $tag_obj->first()->Blogs();
			}		
			
		} else {
			return array(
						'results'			=>	false,
						'error'				=>	'search term is empty'
					);
		}
		
		
		
		$results->merge($work_results);
		$results->merge($blog_results);
		
		return array( 'results' => $results->exclude(array('ClassName' => self::$IGNORES))->sort(array('ID' => 'DESC')));
	}
}