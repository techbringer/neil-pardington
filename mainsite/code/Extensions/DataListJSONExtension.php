<?php

class DataListJSONExtension extends Extension
{
    public function json()
    {
        $lst                =   $this->owner;
        $json_list          =   array();

        foreach ($lst as $item) {
            if (method_exists($item, 'cached')) {
                $json_list[]    =  $item->cached(true);
            }
        }

        return $json_list;
    }
}
