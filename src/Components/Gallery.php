<?php

namespace Igniter\Orange\Components;

use Igniter\Local\Facades\Location;

class Gallery extends \Igniter\System\Classes\BaseComponent
{
    public $isHidden = true;

    public function onRun()
    {
        $locationCurrent = Location::current();
        $gallery = $locationCurrent->getGallery();

        $this->id = uniqid($this->alias);
        $this->page['gallery'] = $gallery;
    }
}
