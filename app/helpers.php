<?php

use Illuminate\Support\Facades\App;
use App\Services\AuditService;

if (!function_exists('audit')) {
    function audit(): AuditService
    {
        return App::make(AuditService::class);
    }
}
