<?php use SaltedHerring\Grid as Grid;

class WorksPage extends Page {
	
	protected static $allowed_children = array(
		'CategoryPage'
	);

	protected static $db = array(
	);

	protected static $has_one = array(
	);
	
	protected static $has_many = array(
		'Works'			=>	'Work'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('HeaderImage');
		
		if (!empty($this->ID)) {
			$fields->addFieldsToTab(
				'Root.Works',
				array(
					Grid::make('Works', 'Works', $this->Works())
				)
			);
		}
		
		return $fields;
	}
	
}


class WorksPage_Controller extends Page_Controller {
	public function allWorks() {
		return $this->Works()->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'));
	}
}