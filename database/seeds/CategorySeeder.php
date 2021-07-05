<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = new Category();
        $categories->name = 'Công nghệ';
        $categories->description = 'Cài đặt phần mềm, ứng dụng';
        $categories->user_id = '1';
        $categories->status = 1;
        $categories->save();

        $categories = new Category();
        $categories->name = 'Thiết bị, máy móc';
        $categories->description = 'Máy tính, màn hình, thiết bị công nghệ';
        $categories->user_id = '1';
        $categories->status = 1;
        $categories->save();

        $categories = new Category();
        $categories->name = 'Y tế';
        $categories->description = 'Chăm sóc sức khoẻ';
        $categories->user_id = '1';
        $categories->status = 1;
        $categories->save();

        $categories = new Category();
        $categories->name = 'Tài khoản';
        $categories->description = 'Mở, khoá, hỗ trợ tài khoản';
        $categories->user_id = '2';
        $categories->status = 1;
        $categories->save();

        $categories = new Category();
        $categories->name = 'Cơ sở vật chất';
        $categories->description = 'Bàn ghế';
        $categories->user_id = '2';
        $categories->status = 2;
        $categories->save();

        $categories = new Category();
        $categories->name = 'VPN';
        $categories->description = 'Kết nối mạng';
        $categories->user_id = '2';
        $categories->status = 1;
        $categories->save();
    }
}
