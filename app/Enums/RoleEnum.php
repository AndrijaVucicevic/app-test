<?php


namespace App\Enums;


enum RoleEnum: string
{
    case ADMIN = 'admin';
    case AUTHOR = 'author';
    case CUSTOMER = 'customer';
}
