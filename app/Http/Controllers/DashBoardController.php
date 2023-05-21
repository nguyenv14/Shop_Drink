<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\ManipulationActivity;
use App\Models\ConfigWeb;
use App\Models\CompanyConfig;
use App\Models\Statistical;
use Carbon\Carbon;

session_start();

class DashBoardController extends Controller
{
    
    public function filter_doanh_thu(Request $request){
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $chart_data = array();
        $statitiscal = Statistical::whereBetween('order_date', [$date_from, $date_to])->orderby('order_date', 'ASC')->get();
        // dd($statitiscal);
        foreach($statitiscal as $value){
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            );
        }
        
        $data = json_encode($chart_data);
        // dd($data);
        echo $data;
    }

    
    public function doanh_thu_five_day(Request $request){
        $sub5day = Carbon::now('Asia/Ho_Chi_Minh')->subdays(5)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistical::whereBetween('order_date', [$sub5day, $now])->orderby('order_date', 'ASC')->get();
        // dd($get);
        $chart_data = array();
        foreach($get as $key => $value){
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            );
        }

        echo json_encode($chart_data);
    }



    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
}

