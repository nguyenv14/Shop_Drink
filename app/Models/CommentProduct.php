<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProduct extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id' ,  'customer_id' ,   'title_comment' ,   'content_comment' , 'created_at', /* Trường Trong Bảng */
    ]; 
    protected $primaryKey =  'id_comment_product'; /* Khóa Chính */
    protected $table =   'tbl_comment_product'; /* Tên Bảng */

}
