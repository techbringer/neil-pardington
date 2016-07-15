<?php use SaltedHerring\Utilities as Utilities;

class Tag extends DataObject {
	protected static $db = array(
		'Title'			=>	'Varchar(1024)',
		'Slag'			=>	'Varchar(1024)',
		'Content'		=>	'HTMLText'
	);
	
	protected static $belongs_many_many = array(
        'Works'			=>	'Work.Tags',
		'Blogs'			=>	'BlogEntry.Tags'
    );
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		
		return $fields;
	}
	
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$slag = Utilities::sanitiseClassName($this->Title);
		$this->Slag = Utilities::SlagGen('Tag', $slag, $this->ID);
	}
	
}