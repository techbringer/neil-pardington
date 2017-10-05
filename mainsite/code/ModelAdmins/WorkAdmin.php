<?php
/**
 * @file WorkAdmin.php
 *
 * Left-hand-side tab : Admin tags
 * */

class WorkAdmin extends ModelAdmin
{
    private static $managed_models  =   ['Work'];
    private static $url_segment     =   'works';
    private static $menu_title      =   'All Works';
    // private static $menu_icon       =   'mainsite/images/tag.png';

    public function getEditForm($id = null, $fields = null) {

        $form = parent::getEditForm($id, $fields);

        $grid = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass));
        $grid->getConfig()
            ->removeComponentsByType('GridFieldPaginator')
            ->removeComponentsByType('GridFieldExportButton')
            ->removeComponentsByType('GridFieldPrintButton')
            ->addComponents(
                new GridFieldPaginatorWithShowAll(30),
                new GridFieldOrderableRows('SortOrder')
            );
        return $form;
    }
}
