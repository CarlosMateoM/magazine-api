<?php

namespace App\Enums;

enum RoleType: string
{
    case ADMIN = 'admin';
    case WRITER = 'writer';
    case READER = 'reader';
}