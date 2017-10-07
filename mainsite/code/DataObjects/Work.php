<?php
use SaltedHerring\Utilities;
use SaltedHerring\SaltedCache;

class Work extends DataObject {
    protected static $db = array(
        'SortOrder'         =>  'Int',
        'Title'             =>  'Varchar(1024)',
        'Slag'              =>  'Varchar(1024)',
        'Content'           =>  'HTMLText'
    );

    /**
     * Default sort ordering
     * @var array
     */
    private static $default_sort = ['SortOrder' => 'ASC'];

    private static $create_table_options = array(
        'MySQLDatabase'     =>  'ENGINE=MyISAM'
    );

    private static $searchable_fields = array(
        'Title',
        'Content'
    );

    protected static $has_one = array(
        'Category'          =>  'Category'
    );

    protected static $summary_fields = array(
        'Category.Title'    =>  'Category',
        'Title'             =>  'Title'
    );

    protected static $many_many = array(
        'Tags'              =>  'Tag'
    );

    protected static $extensions = array(
        'HeaderImageExtension',
        'SearchableExtension'
    );

    public function forTemplate() {
        return $this->customise(array(
                    'Title'                 =>  $this->Title,
                    'Content'               =>  $this->Content,
                    'Category'              =>  $this->Category()->Title,
                    'ViewportHeight'        =>  $this->ViewportHeight,
                    'ViewportCustomHeight'  =>  $this->ViewportCustomHeight,
                    'HeaderImage'           =>  $this->HeaderImage()
                ))->renderWith('Work');
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

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->OnPageID = WorksPage::get()->first()->ID;
        $slag = Utilities::sanitiseClassName($this->Title);
        $this->Slag = Utilities::SlagGen('Work', $slag, $this->ID);
    }

    /**
     * Event handler called after writing to the database.
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();
        $this->cached();
    }

    public function cached($json_format = false, $force = false)
    {
        $factory                        =   $this->ClassName;
        $key                            =   $this->ID . '_' . strtotime($this->LastEdited);

        $data                           =   SaltedCache::read($factory, $key);

        if (empty($data) || $force) {

            $data = array(
                'Title'                 =>  $this->Title,
                'Slug'                  =>  $this->Slag,
                'Content'               =>  $this->Content,
                'Category'              =>  $this->Category()->Title,
                'ViewportHeight'        =>  $this->ViewportHeight,
                'ViewportCustomHeight'  =>  $this->ViewportCustomHeight,
                'HeaderImage'           =>  $this->HeaderImage()->URL
            );

            SaltedCache::save($factory, $key, $data);
        }

        if ($json_format) {
            return $data;
        }

        return new ArrayData($data);
    }

}
