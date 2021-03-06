<?php use SaltedHerring\Utilities as Utilities;

class Work extends DataObject {
	protected static $db = array(
		'SortOrder'		=>	'Int',
		'Title'			=>	'Varchar(1024)',
		'Slag'			=>	'Varchar(1024)',
		'Content'		=>	'HTMLText'
	);
	
	private static $create_table_options = array(
		'MySQLDatabase'		=> 'ENGINE=MyISAM'
    );
	
	private static $searchable_fields = array(
		'Title',
		'Content'
	);
	
	protected static $has_one = array(
		'OnPage'		=>	'WorksPage',
		'Category'		=>	'Category'
	);
	
	protected static $summary_fields = array(
		'theCategory',
		'Title'
	);
	
	protected static $field_labels = array(
		'theCategory'	=>	'Category'
	);
		
	protected static $many_many = array(
        'Tags'			=>	'Tag'
    );
	
	protected static $extensions = array(
		'HeaderImageExtension',
		'SearchableExtension'
	);
	
	public function forTemplate() {
		return $this->customise(array(
					'Title'					=>	$this->Title,
					'Content'				=>	$this->Content,
					'Category'				=>	$this->theCategory(),
					'ViewportHeight'		=>	$this->ViewportHeight,
					'ViewportCustomHeight'	=>	$this->ViewportCustomHeight,
					'HeaderImage'			=>	$this->HeaderImage()
				))->renderWith('Work');
	}
	
	public function theCategory() {
		if ($category = DataObject::get_one('Category', array('ID' => $this->CategoryID))) {
			return $category->Title;
		}
		return 'Uncategorised';
	}
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->removeByName('Tags');
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
		$this->OnPageID = WorksPage::get()->first()->ID;
		$slag = Utilities::sanitiseClassName($this->Title);
		$this->Slag = Utilities::SlagGen('Work', $slag, $this->ID);
	}
	
}