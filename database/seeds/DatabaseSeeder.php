<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        DB::table('departments')->delete();
        $this->call(DepartmentsTableSeeder::class);

        DB::table('users')->delete();
        $this->call(UsersTableSeeder::class);
        $this->call(RolePermissionSeeder::class);

        DB::table('lines')->delete();
        $this->call(LinesTableSeeder::class);

        DB::table('micro_pcs')->delete();
        $this->call(MicroPCsTableSeeder::class);

        DB::table('files')->delete();
        $this->call(FilesTableSeeder::class);

        DB::table('controlpcs')->delete();
        $this->call(ControlPCsTableSeeder::class);

        DB::table('setting')->delete();
        $this->call(SettingTableSeeder::class);
    }
}
