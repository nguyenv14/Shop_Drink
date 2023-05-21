<?php

namespace App\Http\Controllers;

use App\Models\Feeship;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use App\Repositories\SliderRepository\SliderRepositoryInterface;


session_start();

class DeliveryController extends Controller
{
   
    public function show_delivery(){
        $cities = City::whereIn('matp', [48,49])->get();
        $fee_ship = Feeship::paginate(5);
        return view('admin.Delivery.add_delivery')->with(compact('cities', 'fee_ship'));
    }

    public function loading_feeship(){
        $feeship = Feeship::paginate(5);
        $output = '';
        foreach ($feeship as $key => $fee) {
            $output .= '
                    <tr>
                        <td>' . $fee->fee_id . '</td>
                        <td>' . $fee->city->name_city . '</td>
                        <td>' . $fee->province->name_province . '</td>
                        <td>' . $fee->wards->name_ward . '</td>
                        <td contenteditable class="fee_change" data-id_fee ="' . $fee->fee_id . '">' .number_format($fee->fee_feeship, 0, ',', '.').'đ'.'</td>
                        <td>
                        <button  style="border: none" class="btn btn-gradient-danger btn-icon delete_fee" data-toggle="modal" data-target="#Delete" data-id_fee = "' . $fee->fee_id . '"><i style="font-size: 22px" class="mdi mdi-delete-sweep"></i></button>
                        </td>
                    </tr>
                ';
        }
        echo $output;
    }

    public function select_delivery(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == 'city') {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $output .= '<option value=""> ---Chọn Quận Huyện--- </option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value=" ' . $province->maqh . '"> ' . $province->name_province . '</option>';
                }
            } else if ($data['action'] == 'province') {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option value=""> ---Chọn Xã Phường Thị Trấn--- </option>';
                foreach ($select_wards as $key => $ward) {
                    $output .= '<option value=" ' . $ward->xaid . '"> ' . $ward->name_ward . '</option>';
                }
            }
            echo $output;
        }
    }

    public function insert_delivery(Request $request){
        $matp = $request->city;
        $maqh = $request->province;
        $maxp = $request->wards;
        $fee_ship = $request->fee_ship;

        $output = '';
        $check_ward = Feeship::where('fee_maxp', $maxp)->first();

        if($check_ward){
            $output = 'error';
        }else{
            $feeship = new Feeship();
            $feeship->fee_matp = $matp;
            $feeship->fee_maqh = $maqh;
            $feeship->fee_maxp = $maxp;
            $feeship->fee_feeship = $fee_ship;
            $feeship->save();
            $output = 'success';
        }

        echo $output;
    }

    public function delete_delivery(Request $request)
    {      
        $data = $request->all();
        $feeship =  Feeship::where('fee_id', $data['feeship_id'])->first();
        $feeship->delete();
    }

    public function update_delivery(Request $request)
    {      
        $data = $request->all();
        $feeship =  Feeship::where('fee_id', $data['feeship_id'])->first();
        $data_feeship = rtrim($data['feeship_value'] , '.');
        $data_feeship = rtrim($data['feeship_value'] , 'đ');
        $feeship->fee_feeship = $data_feeship;
        $feeship->save();
    }

    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
    
}
