<?php


namespace App\Traits;


trait UserLabelTrait
{

    public function getFullNameLabel(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
