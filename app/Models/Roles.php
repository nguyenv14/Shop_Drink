<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    // use HasFactory;

    public $timestamp = false;
    protected $filltable = [
        'roles_name' // trường trong bảng
    ];

    protected $primaryKey =  'roles_id'; /* Khóa Chính */
    protected $table =   'tbl_roles'; /* Tên Bảng */
    public function admin(){
        return $this->belongsToMany('App\Models\Admin');
    }
}
