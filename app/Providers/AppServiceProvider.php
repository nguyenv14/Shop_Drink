<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ConfigWeb;
use App\Models\CompanyConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        //
        view()->composer('*', function ($view) {
            /* Biến Toàn View Của Back-End */

            // if(session()->has('impersonate')){
            //     $admin_id = session()->get('impersonate');
            // }else{
            //     $admin_id = Auth::id();
            // }
            // $admin = Admin::where('admin_id',$admin_id)->first();
            // $admin_roles =  $admin->viewRoles(); 
            // $roles_name = $admin_roles->roles_name;

            /* Biến Toàn View Của Font-End */
          
            $config_logo_web = ConfigWeb::where('config_type', 1)->orderby('config_id', "DESC")->first();
            $config_slogan_web = ConfigWeb::where('config_type', 2)->orderBy('config_id', "DESC")->take(4)->get();
            $config_brand_web = ConfigWeb::where('config_type', 3)->inRandomOrder()->take(4)->get();
            $company_config = CompanyConfig::where('company_id', 1)->first();
            $view->with(compact('config_logo_web', 'config_slogan_web', 'config_brand_web', 'company_config'));


        });

    }
}
