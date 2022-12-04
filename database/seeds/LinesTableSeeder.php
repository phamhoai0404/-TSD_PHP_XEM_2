<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('MIX_ENV_MODE') !== 'production') {
            DB::table('lines')->insert([
                [
                    'lineCode' => 'LINE_001',
                    'note' => 'Note for line',
                    'userId' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'lineCode' => 'LINE_002',
                    'note' => 'Note for line',
                    'userId' => 5,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'lineCode' => 'LINE_003',
                    'note' => 'Note for line',
                    'userId' => 7,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            ]);
        }
    }
}
