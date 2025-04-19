<?php

namespace App\Http\Controllers;

use App\Models\CommentProduct;
use App\Models\Customers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentProductController extends Controller
{
    public function uploadComment(Request $request) {
        
        $dataComment = $request->all();

        $commentProduct = new CommentProduct;
        $commentProduct->product_id = $request->product_id;
        $commentProduct->customer_id = $request->customer_id;
        $commentProduct->title_comment = $request->title_comment;
        $commentProduct->content_comment = $request->content_comment;

        $commentProduct->save();

        // $testComment = 'đã hoàn thành post Cmt';
        return $dataComment;
    }


    public function reloadComment(Request $request) {
        $product_id = $request->product_id;
        Carbon::setLocale('vi');
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $output = '';
        $dataCommentLoad = CommentProduct::where('product_id', $product_id)->orderBy('id_comment_product', 'DESC')->get();
        if(count($dataCommentLoad))
        {
            foreach ($dataCommentLoad as $key => $subComment) {
                $date = Carbon::create($subComment->created_at, 'Asia/Ho_Chi_Minh');
                $customer_id = $subComment->customer_id;
                $infoCustomer = Customers::where('customer_id', $customer_id)->first();
                $customer_name = $infoCustomer->customer_name;

                $output .= '

                    <div class="userswrite">
                        <div class="userswrite-boxone">
                            <div class="userswrite-boxone-imgusers">
                                <div class="userswrite-boxone-imgusers-element">
                                    <span>T</span>
                                </div>
                            </div>
                            <div class="userswrite-boxone-infousers">
                                <div class="userswrite-boxone-infousers-box">
                                    <div class="userswrite-boxone-infousers-title">
                                        <span>' . $customer_name . '</span>
                                    </div>
                                    <div class="userswrite-boxone-infousers-item">
                                        <span class="userswrite-boxone-infousers-item-text">' .  $date->diffForHumans($now) . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="userswrite-boxtwo">
                            <div class="userswrite-boxtwo-title">
                                <span>' . $subComment->title_comment . '</span>
                            </div>
                            <div class="userswrite-boxtwo-content">
                                <span>' . $subComment->content_comment . '</span>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        else
        {
            $output .= '
                <div class="">
                    <p><b>Không có bình luận nào!</b></p>
                </div>
            ';
            // return $output;
        }
        return $output;
    }
    public function reloadTop5Comment(Request $request) {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        // dd($now);
        $product_id = $request->product_id;
        $output = '';
        $olddataCommentLoad = CommentProduct::orderBy('id_comment_product', 'DESC')->where('product_id', $product_id)->take(5)->get();
        // $dataCommentLoad = $olddataCommentLoad->reverse();
        if(count($olddataCommentLoad))
        {
            foreach ($olddataCommentLoad as $key => $subComment) {
                Carbon::setLocale('vi');
                $customer_id = $subComment->customer_id;
                $infoCustomer = Customers::where('customer_id', $customer_id)->first();
                $customer_name = $infoCustomer->customer_name;
                $date = Carbon::create($subComment->created_at, 'Asia/Ho_Chi_Minh');
                // dd($date);
                // $date-
                $output .= '

                    <div class="userswrite">
                        <div class="userswrite-boxone">
                            <div class="userswrite-boxone-imgusers">
                                <div class="userswrite-boxone-imgusers-element">
                                    <span>T</span>
                                </div>
                            </div>
                            <div class="userswrite-boxone-infousers">
                                <div class="userswrite-boxone-infousers-box">
                                    <div class="userswrite-boxone-infousers-title">
                                        <span>' . $customer_name . '</span>
                                    </div>
                                    <div class="userswrite-boxone-infousers-item">
                                        <span class="userswrite-boxone-infousers-item-text">' . $date->diffForHumans($now) . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="userswrite-boxtwo">
                            <div class="userswrite-boxtwo-title">
                                <span>' . $subComment->title_comment . '</span>
                            </div>
                            <div class="userswrite-boxtwo-content">
                                <span>' . $subComment->content_comment . '</span>
                            </div>
                        </div>
                    </div>
                ';
            }

            // echo $output;
        }
        else
        {
            $output .= '
                <div class="">
                    <p><b>Không có bình luận nào!</b></p>
                </div>
            ';
            // return $output;
        }
        return $output;
    }

    public function all_comment(){
        
    }
}
