<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( env('MIX_ENV_MODE') === 'production') {
            DB::table('users')->insert([
                [
                    'userCode' => 'IT01',
                    'depId' => 1,
                    'note' => '',
                    'password' => bcrypt('IT@202'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'IT02',
                    'depId' => 1,
                    'note' => '',
                    'password' => bcrypt('IT@202'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'Pe01',
                    'depId' => 2,
                    'note' => '',
                    'password' => bcrypt('Pe01@321'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'Pe02',
                    'depId' => 2,
                    'note' => '',
                    'password' => bcrypt('Pe01@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'ASSY101',
                    'depId' => 3,
                    'note' => '',
                    'password' => bcrypt('ASSY1@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'ASSY102',
                    'depId' => 3,
                    'note' => '',
                    'password' => bcrypt('ASSY1@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'SMT01',
                    'depId' => 4,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'SMT02',
                    'depId' => 4,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'WH01',
                    'depId' => 5,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'WH02',
                    'depId' => 5,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'ASSY201',
                    'depId' => 6,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'ASSY202',
                    'depId' => 6,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'ID01',
                    'depId' => 7,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'ID02',
                    'depId' => 7,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'QA01',
                    'depId' => 8,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'QA02',
                    'depId' => 8,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'PC01',
                    'depId' => 9,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'PC02',
                    'depId' => 9,
                    'note' => '',
                    'password' => bcrypt('TVN@123'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        } else {
            DB::table('users')->insert([
                [
                    'userCode' => 'TVN_KT_0001',
                    'depId' => 0,
                    'note' => 'Note for admin',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_PE_0002',
                    'depId' => 0,
                    'note' => 'Note for pe',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_CN_0003',
                    'depId' => 1,
                    'note' => 'Note for worker',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_CN_0004',
                    'depId' => 1,
                    'note' => 'Note for worker',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_CN_0005',
                    'depId' => 2,
                    'note' => 'Note for worker',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_CN_0006',
                    'depId' => 2,
                    'note' => 'Note for worker',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_CN_0007',
                    'depId' => 3,
                    'note' => 'Note for worker',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'userCode' => 'TVN_CN_0008',
                    'depId' => 3,
                    'note' => 'Note for worker',
                    'password' => bcrypt('secret'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        }
    }
}
