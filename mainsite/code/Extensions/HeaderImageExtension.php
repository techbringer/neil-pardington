<?php use SaltedHerring\Debugger as Debugger;

class HeaderImageExtension extends DataExtension {
	
	protected static $db = array(
		'ViewportHeight'		=>	'Varchar(32)',
		'ViewportCustomHeight'	=>	'Int'
	);
	
	protected static $has_one = array(
		'HeaderImage'	=>	'Image'
	);
	
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldsToTab(
			'Root.HeaderImage',
			array(
				UploadField::create('HeaderImage')->setAllowedFileCategories('image'),
				DropdownField::create('ViewportHeight', 'Header image height', Config::inst()->get('HeaderImage', 'heights'))->setEmptyString('- select one -'),
				TextField::create('ViewportCustomHeight')->setAttribute('placeholder', 'e.g. 400')->setDescription('number in px, use only when "Custom..." selected in last field')
			)
		);
		
	}
}