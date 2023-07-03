<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    /**
     * Get the post that owns the comment.
     */
    public function permissionsGroup()
    {
        return $this->belongsTo('App\Models\PermissionsGroup');
    }
}
