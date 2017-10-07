<?php

class BusinessDirector extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Name'      =>  'Varchar(32)',
        'Position'  =>  'Varchar(64)',
        'Phone'     =>  'Varchar(32)',
        'Email'     =>  'Varchar(256)'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'SortOrderExtension'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'onPage'    =>  'Page',
        'Portrait'  =>  'Image'
    ];

    public function forTemplate()
    {
        return $this->renderWith(['Director']);
    }
}
