<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolesUser extends Pivot
{
    use HasFactory;
    protected $table = 'rolesusers';

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public $incrementing = true;

}
