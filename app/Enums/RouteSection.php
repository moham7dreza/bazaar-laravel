<?php

namespace App\Enums;

enum RouteSection: string
{
    case ADMIN = 'admin';
    case ADVERTISE = 'advertise';
    case CONTENT = 'content';
    case USERS = 'users';
    case PANEL = 'panel';
    case GALLERY = 'gallery';
    case NOTES = 'notes';
    case FAVORITES = 'favorites';
    case HISTORY = 'history';
    case IMAGES = 'images';
}
