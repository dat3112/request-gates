<?php

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = new Priority();
        $priorities->name = 'Low';
        $priorities->description = 'Thấp';
        $priorities->save();

        $priorities = new Priority();
        $priorities->name = 'Medium';
        $priorities->description = 'Trung bình';
        $priorities->save();

        $priorities = new Priority();
        $priorities->name = 'High';
        $priorities->description = 'Cao';
        $priorities->save();

        $priorities = new Priority();
        $priorities->name = 'Critical';
        $priorities->description = 'Khẩn cấp';
        $priorities->save();
    }
}
