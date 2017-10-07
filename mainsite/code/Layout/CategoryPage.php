<?php

use SaltedHerring\Grid;
use SaltedHerring\Debugger;
use SaltedHerring\SaltedCache;

class CategoryPage extends Page
{
    protected static $db = array(
    );

    protected static $has_one = array(
    );

    protected static $has_many = array(
        'SubCategories'     =>    'Category'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('HeaderImage');
        if (!empty($this->ID)) {
            $fields->addFieldsToTab(
                'Root.SubCategories',
                array(
                    Grid::make('SubCategories', 'Sub Categories', $this->SubCategories())
                )
            );
        }
        return $fields;
    }

    public function mySubCategories()
    {
        return $this->SubCategories()->sort(array('SortOrder' => 'ASC'));
    }

    public function getCachedWorks()
    {
        $factory                        =   $this->ClassName;
        $key                            =   $this->ID . '_' . strtotime($this->LastEdited);

        $data                           =   SaltedCache::read($factory, $key);

        if (empty($data)) {

            $categories                 =   $this->mySubCategories();//->filter(array('slag' => $slag))->first()->Works();
            $list                       =   [];

            foreach ($categories as $category) {
                $list                   =   array_merge($list, $category->Works()->column());
            }
            
            $data                       =   Work::get()->filter(['ID' => $list]);

            SaltedCache::save($factory, $key, $data);
        }

        return $data;
    }

}


class CategoryPage_Controller extends Page_Controller
{
    protected static $url_handlers = array(
        ''              =>  'index',
        '$slag'         =>  'getworks'
    );

    protected static $allowed_actions = array(
        'index',
        'getworks'
    );

    public function index($request) {
        $categories = $this->SubCategories();//->filter(array('slag' => $slag))->first()->Works();
        $works = new ArrayList();

        foreach ($categories as $category) {
            $works->merge($category->Works());
        }

        if ($works->count() == 0) {
            $err = HomePage::get()->first();
            return $this->customise(array(
                    'HeaderImage'        =>    $err->HeaderImage(),
                    'ViewportHeight'    =>    'normal',
                    'HideTitle'            =>    false,
                    'Content'            =>    '<h2>Found no work</h2><p>Load some?</p>'
                ))->renderWith(array('Page'));
        }

        return $this->customise(array(
                    'Title'        =>    $this->Title,
                    'Works'        =>    $works->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'))
                ))->renderWith(array('WorkList', 'Page'));
    }

    public function getworks($request) {
        $slag = $request->param('slag');
        $obj = $this->SubCategories()->filter(array('slag' => $slag))->first();
        $subtitle = $obj->Title;
        $works = $obj->Works();
        if ($works->count() == 0) {
            return $this->customise(array(
                    'HeaderImage'            =>    $this->prepareHeaderImage($obj),
                    'SubTitle'                =>    $subtitle,
                    'ViewportHeight'        =>    'normal',
                    'HideTitle'                =>    false,
                    'Content'                =>    '<h2>Found no work</h2><p>Load some?</p>'
                ))->renderWith(array('Page'));
        }
        return $this->customise(array(
                    'CategoryHeader'        =>    $this->prepareHeaderImage($obj),
                    'ViewportHeight'        =>    $obj->ViewportHeight,
                    'ViewportCustomHeight'    =>    (!empty($obj->ViewportCustomHeight) ? $obj->ViewportCustomHeight : false),
                    'CategoryTitle'            =>    $subtitle,
                    'CategoryIntro'            =>    empty(trim($obj->Content)) ? '- no content' : $obj->Content,
                    'Title'                    =>    $this->Title,
                    'Works'                    =>    $works->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'))
                ))->renderWith(array('WorkList', 'Page'));
    }

    private function prepareHeaderImage($cat) {
        $image = !empty($cat->HeaderImageID) ? $cat->HeaderImage() : HomePage::get()->first()->HeaderImage();
        return $image;
    }

    public function isActive() {
        $request = Controller::curr()->request;
        $slag = $request->param('slag');
        return $slag;
    }

    public function getEndpoint()
    {
        // Debugger::inspect($this->request->param('slag'));
        if ($slug   =   $this->request->param('slag')) {
            return $slug;
        }

        return $this->ID;
    }
}
