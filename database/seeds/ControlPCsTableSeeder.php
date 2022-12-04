<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ControlPCsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('controlpcs')->insert([
            [
                'controlpcCode' => 'PC Client1',
                'ipAddress' => '192.168.36.11',
                'note' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'controlpcCode' => 'PC Client2',
                'ipAddress' => '192.168.36.12',
                'note' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
