<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MicroPCsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('MIX_ENV_MODE') === 'production') {
            DB::table('micro_pcs')->insert([
                [
                    'microCode' => 'MPC001',
                    'ipAddress' => '192.168.36.21',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC002',
                    'ipAddress' => '192.168.36.22',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC003',
                    'ipAddress' => '192.168.36.23',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC004',
                    'ipAddress' => '192.168.36.24',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC005',
                    'ipAddress' => '192.168.36.25',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC006',
                    'ipAddress' => '192.168.36.26',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC007',
                    'ipAddress' => '192.168.36.27',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC008',
                    'ipAddress' => '192.168.36.28',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC009',
                    'ipAddress' => '192.168.36.29',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC010',
                    'ipAddress' => '192.168.36.30',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC011',
                    'ipAddress' => '192.168.36.31',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC012',
                    'ipAddress' => '192.168.36.32',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC013',
                    'ipAddress' => '192.168.36.33',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC014',
                    'ipAddress' => '192.168.36.34',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC015',
                    'ipAddress' => '192.168.36.35',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC016',
                    'ipAddress' => '192.168.36.36',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC017',
                    'ipAddress' => '192.168.36.37',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC018',
                    'ipAddress' => '192.168.36.38',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC019',
                    'ipAddress' => '192.168.36.39',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC020',
                    'ipAddress' => '192.168.36.40',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC021',
                    'ipAddress' => '192.168.36.41',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC022',
                    'ipAddress' => '192.168.36.42',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC023',
                    'ipAddress' => '192.168.36.43',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC024',
                    'ipAddress' => '192.168.36.44',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC025',
                    'ipAddress' => '192.168.36.45',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC026',
                    'ipAddress' => '192.168.36.46',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC027',
                    'ipAddress' => '192.168.36.47',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC028',
                    'ipAddress' => '192.168.36.48',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC029',
                    'ipAddress' => '192.168.36.49',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC030',
                    'ipAddress' => '192.168.36.50',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC031',
                    'ipAddress' => '192.168.36.51',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MPC032',
                    'ipAddress' => '192.168.36.52',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        } else {
            DB::table('micro_pcs')->insert([
                [
                    'microCode' => 'MCR_001',
                    'ipAddress' => '192.168.1.1',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_002',
                    'ipAddress' => '192.168.1.2',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_003',
                    'ipAddress' => '192.168.1.3',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_004',
                    'ipAddress' => '192.168.1.4',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_005',
                    'ipAddress' => '192.168.1.5',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_006',
                    'ipAddress' => '192.168.1.6',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_007',
                    'ipAddress' => '192.168.1.7',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_008',
                    'ipAddress' => '192.168.1.8',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_009',
                    'ipAddress' => '192.168.1.9',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_010',
                    'ipAddress' => '192.168.1.10',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => 2,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_011',
                    'ipAddress' => '192.168.1.11',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_012',
                    'ipAddress' => '192.168.1.12',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_013',
                    'ipAddress' => '192.168.1.13',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_014',
                    'ipAddress' => '192.168.1.14',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_015',
                    'ipAddress' => '192.168.1.15',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_016',
                    'ipAddress' => '192.168.1.16',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_017',
                    'ipAddress' => '192.168.1.17',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_018',
                    'ipAddress' => '192.168.1.18',
                    'note' => 'note for micropc',
                    'depId' => 1,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_019',
                    'ipAddress' => '192.168.1.19',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_020',
                    'ipAddress' => '192.168.1.20',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_021',
                    'ipAddress' => '192.168.1.21',
                    'note' => 'note for micropc',
                    'depId' => 2,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_022',
                    'ipAddress' => '192.168.1.22',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_023',
                    'ipAddress' => '192.168.1.23',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'microCode' => 'MCR_024',
                    'ipAddress' => '192.168.1.24',
                    'note' => 'note for micropc',
                    'depId' => 3,
                    'lineId' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        }
    }
}
