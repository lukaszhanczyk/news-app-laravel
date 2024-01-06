<?php

namespace App\Http\Services\Updaters;

class Updater
{
    protected function getObjectFromArray($name, $array) {
        $id = $this->searchForId($name, $array);
        if ($id){
            return $array[$id];
        }
        return null;
    }

    protected function searchForId($name, $array): bool|int|string
    {
        return array_search($name, array_column($array, 'name'));
    }
}
