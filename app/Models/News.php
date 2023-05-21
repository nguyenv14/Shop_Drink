<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'news_title' ,  'news_image' , 'display', 'created_at', /* Trường Trong Bảng */
    ]; 
    protected $primaryKey =  'id_news'; /* Khóa Chính */
    protected $table =   'tbl_news'; /* Tên Bảng */

    public function subnews(){
        return $this->belongsTo('App\Models\SubNews', 'id_news', 'id_news'); // tham số thứ 2 lấy từ tbl_product và tham số thứ 3 lấy từ tbl_flashsale
    }
}
