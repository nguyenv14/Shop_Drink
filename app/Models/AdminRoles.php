<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRoles extends Model
{
    public $timestamp = false;
    protected $filltable = [
        'admin_admin_id', 'roles_id' // trường trong bảng
    ];

    protected $primaryKey =  'admin_roles_id'; /* Khóa Chính */
    protected $table =   'tbl_admin_roles'; /* Tên Bảng */
    
}
