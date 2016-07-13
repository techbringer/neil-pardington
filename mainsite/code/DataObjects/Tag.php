<?php

class Tag extends DataObject {
	protected static $db = array(
		'Title'			=>	'Varchar(1024)',
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
	
}