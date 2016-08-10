<?php 

use SaltedHerring\Grid as Grid;
use SaltedHerring\Debugger as Debugger;

class CategoryPage extends Page {
	
	protected static $can_be_root = false;

	protected static $db = array(
	);

	protected static $has_one = array(
	);
	
	protected static $has_many = array(
		'SubCategories'		=>	'Category'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('HeaderImage');
		if (!empty($this->ID)) {
			$fields->addFieldsToTab(
				'Root.SubCategories',
				array(
					Grid::make('SubCategories', 'Sub Categories', $this->SubCategories())
				)
			);
		}
		return $fields;
	}
	
	public function mySubCategories() {
		return $this->SubCategories()->sort(array('SortOrder' => 'ASC'));
	}
}


class CategoryPage_Controller extends Page_Controller {
	protected static $url_handlers = array(
		''		=>	'index',
		'$slag'	=>  'getworks'
	);
	
	protected static $allowed_actions = array(
		'index',
		'getworks'
	);
	
	public function index($request) {
		$categories = $this->SubCategories();//->filter(array('slag' => $slag))->first()->Works();
		$works = new ArrayList();
		
		foreach ($categories as $category) {
			$works->merge($category->Works());
		}
		
		if ($works->count() == 0) {
			$err = HomePage::get()->first();
			return $this->customise(array(
					'HeaderImage'		=>	$err->HeaderImage(),
					'ViewportHeight'	=>	'normal',
					'HideTitle'			=>	false,
					'Content'			=>	'<h2>Found no work</h2><p>Load some?</p>'
				))->renderWith(array('Page'));
		}
		
		return $this->customise(array(
					'Title'		=>	$this->Title,
					'Works'		=>	$works->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'))
				))->renderWith(array('WorkList', 'Page'));
	}
	
	public function getworks($request) {
		$slag = $request->param('slag');
		$obj = $this->SubCategories()->filter(array('slag' => $slag))->first();
		$subtitle = $obj->Title;
		$works = $obj->Works();
		if ($works->count() == 0) {
			$err = HomePage::get()->first();
			return $this->customise(array(
					'HeaderImage'		=>	$err->HeaderImage(),
					'SubTitle'			=>	$subtitle,
					'ViewportHeight'	=>	'normal',
					'HideTitle'			=>	false,
					'Content'			=>	'<h2>Found no work</h2><p>Load some?</p>'
				))->renderWith(array('Page'));
		}
		return $this->customise(array(
					'Title'		=>	$this->Title,
					'Works'		=>	$works->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'))
				))->renderWith(array('WorkList', 'Page'));
	}
	
	public function isActive() {
		$request = Controller::curr()->request;
		$slag = $request->param('slag');
		return $slag;
	}
	
}