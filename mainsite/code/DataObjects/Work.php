<?php use SaltedHerring\Utilities as Utilities;

class Work extends DataObject {
	protected static $db = array(
		'SortOrder'		=>	'Int',
		'Title'			=>	'Varchar(1024)',
		'Slag'			=>	'Varchar(1024)',
		'Content'		=>	'HTMLText'
	);
	
	protected static $has_one = array(
		'OnPage'		=>	'WorksPage',
		'HeaderImage'	=>	'Image'
	);
	
	protected static $belongs_to = array(
		'Category'		=>	'Category'
	);
	
	protected static $many_many = array(
        'Tags'			=>	'Tag'
    );
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->addFieldToTab(
			'Root.Main',
			UploadField::create('HeaderImage')->setAllowedFileCategories('image'),
			'Content'
		);
		
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
			'OnPageID'
		);
		$fields->removeByName('OnPageID');
		return $fields;
	}
	
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$slag = Utilities::sanitiseClassName($this->Title);
		$this->Slag = Utilities::SlagGen('Work', $slag, $this->ID);
	}
	
}