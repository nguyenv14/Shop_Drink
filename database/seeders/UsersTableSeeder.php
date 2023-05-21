<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::truncate();

        $adminRoles = Roles::where('roles_name', 'admin')->first();
        $managerRoles = Roles::where('roles_name', 'manager')->first();
        $employeeRoles = Roles::where('roles_name', 'employee')->first();

        $admin = Admin::create([
            'admin_name' => 'nguyên admin',
            'admin_email' => 'nguyenadmin@gmail.com',
            'admin_phone' =>  '0839519415',
            'admin_password' => md5('123456')
        ]);

        $manage = Admin::create([
            'admin_name' => 'nguyên manager',
            'admin_email' => 'nguyenmanager@gmail.com',
            'admin_phone' =>  '0839519415',
            'admin_password' => md5('123456')
        ]);

        $employee = Admin::create([
            'admin_name' => 'nguyên employee',
            'admin_email' => 'nguyenemployee@gmail.com',
            'admin_phone' =>  '0839519415',
            'admin_password' => md5('123456')
        ]);


        $admin->roles()->attach($adminRoles);
        $manage->roles()->attach($managerRoles);
        $employee->roles()->attach($employeeRoles);

    }
}
