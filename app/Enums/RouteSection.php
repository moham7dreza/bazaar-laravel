<?php

declare(strict_types=1);

namespace App\Enums;

enum RouteSection: string
{
    case ADMIN          = 'admin';
    case ADVERTISEMENTS = 'advertisements';
    case CONTENT        = 'content';
    case USERS          = 'users';
    case PANEL          = 'panel';
    case GALLERY        = 'gallery';
    case NOTES          = 'notes';
    case FAVORITES      = 'favorites';
    case HISTORY        = 'history';
    case IMAGES         = 'images';
    case AUTH           = 'auth';
}
