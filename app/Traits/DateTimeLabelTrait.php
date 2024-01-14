<?php


namespace App\Traits;

use App\Helpers\DateTimeHelper;

trait DateTimeLabelTrait
{

    public function getCreatedAtLabel(): string
    {
        return DateTimeHelper::webDateFormat($this->created_at);
    }

    public function getCreatedAtDateTimeLabel()
    {
        return DateTimeHelper::webDateTimeFormat($this->created_at);
    }

    public function getUpdatedAtLabel(): string
    {
        return DateTimeHelper::webDateFormat($this->updated_at);
    }

    public function getUpdatedAtDateTimeLabel()
    {
        return DateTimeHelper::webDateTimeFormat($this->updated_at);
    }

}