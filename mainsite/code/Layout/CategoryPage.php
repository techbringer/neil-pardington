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
		
		return $this->renderWith(array('Page'));
	}
	
	public function getworks($request) {
		$slag = $request->param('slag');
		$works = $this->SubCategories()->filter(array('slag' => $slag))->first()->Works();
		
		return $this->customise(array(
					'Works'		=>	$works
				))->renderWith(array('WorkList', 'Page'));
	}
	
}