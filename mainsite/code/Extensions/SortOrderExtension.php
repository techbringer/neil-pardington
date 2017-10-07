<?php

class SortOrderExtension extends DataExtension {
	private static $db = array(
		'SortOrder' => 'Int'
	);

	private static $default_sort = 'SortOrder ASC';

	public function updateCMSFields(FieldList $fields) {
		$fields->removeFieldsFromTab("Root.Main", array(
			'SortOrder'
		));
	}
}
