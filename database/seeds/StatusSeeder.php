<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = new Status();
        $statuses->name = 'Open';
        $statuses->save();

        $statuses = new Status();
        $statuses->name = 'In progress';
        $statuses->save();

        $statuses = new Status();
        $statuses->name = 'Close';
        $statuses->save();
    }
}
