<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\ManipulationActivity;
use App\Models\ConfigWeb;
use App\Models\CompanyConfig;
session_start();

class CompanyConfigController extends Controller
{
    public function show_company_config(){
        $company_config = CompanyConfig::where('company_id', 1)->first();
        return view('admin.Config-footer.CompanyConfig')->with('company_config', $company_config);
    }

    public function edit_content_footer(Request $request){
        $content_edit = $request->content_edit;
        $config_type = $request->edit_type;

        $company_config = CompanyConfig::where('company_id', 1)->first();

        if($config_type == 1){
            $company_config['company_name'] = $content_edit;
        }else if($config_type == 2){
            $company_config['company_hostline'] = $content_edit;
        }else if($config_type == 3){
            $company_config['company_mail'] = $content_edit;
        }else if($config_type == 4){
            $company_config['company_address'] = $content_edit;
        }else if($config_type == 5){
            $company_config['company_slogan'] = $content_edit;
        }else if($config_type == 6){
            $company_config['company_copyright'] = $content_edit;
        }
        $company_config->save();
        
    }


    




    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
}

