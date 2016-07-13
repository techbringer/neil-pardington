<?php use SaltedHerring\Utilities as Utilities;

class BlogEntry extends DataObject {
	protected static $db = array(
		'Title'			=>	'Varchar(1024)',
		'Slag'			=>	'Varchar(1024)',
		'Content'		=>	'HTMLText'
	);
	
	protected static $has_one = array(
		'onPage'		=>	'Page'
	);
	
	protected static $many_many = array(
        'Tags'			=>	'Tag'
    );
	
	protected static $extensions = array(
		'HeaderImageExtension'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeByName('Slag');
		
		if ($this->exists()) {
			$fields->addFieldToTab('Root.Main', ReadonlyField::create('Slag'));
		}
		
		
		$fields->addFieldToTab(
			'Root.Main',
			TagField::create(
				'Tags',
				'Tags',
				Tag::get(),
				$this->Tags()
			)->setShouldLazyLoad(true)->setCanCreate(true),
			'onPageID'
		);
		
		$fields->removeByName('onPageID');
		return $fields;
	}
	
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$slag = Utilities::sanitiseClassName($this->Title);
		$this->Slag = Utilities::SlagGen('BlogEntry', $slag, $this->ID);
	}
	
}