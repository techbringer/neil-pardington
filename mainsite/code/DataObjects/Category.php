<?php use SaltedHerring\Utilities as Utilities;

class Category extends DataObject {
	protected static $db = array(
		'SortOrder'		=>	'Int',
		'Title'			=>	'Varchar(64)',
		'Slag'			=>	'Varchar(64)',
		'Content'		=>	'HTMLText'
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
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->removeByName('Slag');
		
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