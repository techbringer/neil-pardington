<?php

/**
 * @file TwitteCarExtension
 *
 * Extension to provide support for twitter cards.
 * */
class TwitterCardExtension extends DataExtension {
	private static $db = array(
		'TwitterCard'			=> 'Enum("summary,summary_large_image")',
		'TwitterTitle' 			=> 'Varchar(255)',
		'TwitterDescription'	=> 'Varchar(255)',
	);

	private static $has_one =  array(
		'TwitterImage' 			=> 'Image'
	);

	public function updateCMSFields(FieldList $fields) {
		$baseClass = ClassInfo::baseDataClass($this->owner->class);

		$title = new TextField('TwitterTitle', 'Title');

		// If extending a page, disable access to the title - the page title will suffice.
		if ($baseClass == 'SiteTree') {
			$title = $title->performReadonlyTransformation();
		}

		if (empty($fields->fieldByName('Root.Social.Twitter'))) {
			$twitter = ToggleCompositeField::create(
				'Twitter',
				new LabelField('Twitter', 'Twitter Card Tags'),
				array(
					new DropdownField('TwitterCard', 'Card Type',
						singleton($this->owner->ClassName)->dbObject('TwitterCard')->enumValues()
					),
					$title,
					new TextareaField('TwitterDescription', 'Description'),
					$TwitterImage = SaltedUploader::create('TwitterImage', 'Image')->setCropperRatio(470/246)
				)
			);
			$TwitterImage->setDescription('Image must be at least 880px x 440px.');
			$fields->addFieldToTab('Root.Social', $twitter);
		}
	}
}
