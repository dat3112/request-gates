<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = new Role();
        $roles->name = 'ADMIN';
        $roles->description = 'Admin (thành viên phòng HCNS)';
        $roles->save();

        $roles = new Role();
        $roles->name = 'QLBP';
        $roles->description = 'Quản lý bộ phận';
        $roles->save();

        $roles = new Role();
        $roles->name = 'CBNV';
        $roles->description = 'Cán bộ nhân viên';
        $roles->save();
    }
}
