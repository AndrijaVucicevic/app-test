<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $refreshDatabase = false;

    protected function setUp(): void
    {
        parent::setUp();
        DB::setDefaultConnection('testing_db');

        if ($this->refreshDatabase) {
            $this->refreshDatabase();
        }
    }

    protected function refreshDatabase()
    {
        Artisan::call('migrate:fresh --seed');
    }

}
