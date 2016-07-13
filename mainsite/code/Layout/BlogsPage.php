<?php use SaltedHerring\Grid as Grid;

class BlogsPage extends Page {

	protected static $db = array(
	);

	protected static $has_one = array(
	);
	
	protected static $has_many = array(
		'Blogs'			=>	'BlogEntry'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		if (!empty($this->ID)) {
			$fields->addFieldsToTab(
				'Root.Blogs',
				array(
					Grid::make('Blogs', 'Blogs', $this->Blogs(), false)
				)
			);
		}
		return $fields;
	}
	
}


class BlogsPage_Controller extends Page_Controller {
	
}