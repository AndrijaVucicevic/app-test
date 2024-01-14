<?php


namespace App\Enums\Http;

enum StatusCodeEnum: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case UNPROCESSABLE_CONTENT = 422;
    case SERVER_ERROR = 500;
}
