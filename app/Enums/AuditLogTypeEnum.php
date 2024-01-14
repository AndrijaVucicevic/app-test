<?php


namespace App\Enums;


enum AuditLogTypeEnum: string
{
    case POST_CREATE = 'POST KREIRANJE';
    case POST_UPDATE = 'POST UPDATE';
}
