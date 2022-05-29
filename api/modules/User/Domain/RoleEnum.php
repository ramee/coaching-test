<?php

declare(strict_types=1);

namespace Modules\User\Domain;

enum RoleEnum:string
{
    case Coach = 'Coach';
    case Member = 'Member';
}