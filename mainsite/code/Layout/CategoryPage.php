<?php use SaltedHerring\Grid as Grid;

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
	
}