<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = new Department();
        $departments->name = 'Hành chính nhân sự';
        $departments->department_code = 'HCNS';
        $departments->description = 'Hành chính nhân sự';
        $departments->status = 1;
        $departments->save();

        $departments = new Department();
        $departments->name = 'Bộ phận HBF';
        $departments->department_code = 'HBF';
        $departments->description = 'Bộ phận HBF';
        $departments->status = 1;
        $departments->save();

        $departments = new Department();
        $departments->name = 'Bộ phận HB1';
        $departments->department_code = 'HB1';
        $departments->description = 'Bộ phận HB1';
        $departments->status = 1;
        $departments->save();

        $departments = new Department();
        $departments->name = 'Bộ phận HB2';
        $departments->department_code = 'HB2';
        $departments->description = 'Bộ phận HB2';
        $departments->status = 1;
        $departments->save();

        $departments = new Department();
        $departments->name = 'Bộ phận HB3';
        $departments->department_code = 'HB3';
        $departments->description = 'Bộ phận HB3';
        $departments->status = 1;
        $departments->save();

        $departments = new Department();
        $departments->name = 'Bộ phận HB4';
        $departments->department_code = 'HB4';
        $departments->description = 'Bộ phận HB4';
        $departments->status = 1;
        $departments->save();
    }
}
