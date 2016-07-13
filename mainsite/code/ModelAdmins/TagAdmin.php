<?php
/**
 * @file TagAdmin.php
 *
 * Left-hand-side tab : Admin tags
 * */

class TagAdmin extends ModelAdmin {
	private static $managed_models = array('Tag');
	private static $url_segment = 'tags';
	private static $menu_title = 'Tags';
	private static $menu_icon = 'mainsite/images/tag.png';
	
	public function getEditForm($id = null, $fields = null) {
		
		$form = parent::getEditForm($id, $fields);
				
		$grid = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass));
		$grid->getConfig()
			->removeComponentsByType('GridFieldPaginator')
			->removeComponentsByType('GridFieldExportButton')
			->removeComponentsByType('GridFieldPrintButton')
			->addComponents(
				new GridFieldPaginatorWithShowAll(30)
			);
		return $form;
	}
}