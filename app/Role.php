<?php

namespace App;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    const ROLE_ADMINISTRATOR = 'administrator';

    const ROLE_ADMINISTRATOR_ID = 1;

}
