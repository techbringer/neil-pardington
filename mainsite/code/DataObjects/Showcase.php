<?php use SaltedHerring\Utilities as Utilities;
use SaltedHerring\Debugger as Debugger;

class Showcase extends DataObject {
	protected static $db = array(
		'SortOrder'		=>	'Int',
		'Title'			=>	'Varchar(1024)',
		'Content'		=>	'HTMLText'
	);
	
	protected static $has_one = array(
		'onPage'		=>	'HomePage'
	);
	
	protected static $extensions = array(
		'HeaderImageExtension'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->removeByName('onPageID');
		
		return $fields;
	}
	
	public function onAfterWrite() {
		parent::onAfterWrite();
		$homepages = Versioned::get_by_stage('HomePage', 'Live');
		if ($homepages->count() > 0) {
			$homepage = $homepages->first();
			$homepage->collect_content();
		}
	}
	
	public function contribute_content() {
		$title = $this->Title;
		$content = $this->Content;
		
		return '<h2>' . $title . '</h2>' . $content;
	}
	
	public function forTemplate() {
		return $this->renderWith('Showcase');
	}
}