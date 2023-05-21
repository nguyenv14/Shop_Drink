<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubNews extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id_news' ,  'sub_title' , 'sub_content', /* Trường Trong Bảng */
    ]; 
    protected $primaryKey =  'id_sub_news'; /* Khóa Chính */
    protected $table =   'tbl_sub_news'; /* Tên Bảng */
}
