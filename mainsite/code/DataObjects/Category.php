<?php use SaltedHerring\Utilities as Utilities;

class Category extends DataObject {
	protected static $db = array(
		'SortOrder'		=>	'Int',
		'Title'			=>	'Varchar(64)',
		'Slag'			=>	'Varchar(64)',
		'Content'		=>	'HTMLText'
	);
	
	private static $create_table_options = array(
		'MySQLDatabase'		=> 'ENGINE=MyISAM'
    );
	
	private static $searchable_fields = array(
		'Title',
		'Content'
	);
	
	protected static $extensions = array(
		'HeaderImageExtension',
		'SearchableExtension'
	);
	
	protected static $summary_fields = array(
		'SortOrder',
		'Title'
	);
	
	protected static $has_one = array(
		'inCategory'	=>	'CategoryPage'
	);
	
	protected static $has_many = array(
		'Works'			=>	'Work'
	);
	
	/*public function forTemplate() {
		return $this->renderWith('Category');
	}*/
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->removeByName('Slag');
		$fields->fieldByName('Root.Main.Content')->setTitle('Introduction');
		if ($this->exists()) {
			$fields->addFieldToTab('Root.Main', ReadonlyField::create('Slag'), 'Content');
		}
		
		return $fields;
	}
	
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$slag = Utilities::sanitiseClassName($this->Title);
		$this->Slag = Utilities::SlagGen('Category', $slag, $this->ID);
	}
	
}