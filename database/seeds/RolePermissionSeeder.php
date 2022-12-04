<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Entities\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // quản lý user
        Permission::create([
            'id' => PERMISSION_MANAGE_USER_ID, 
            'name' => PERMISSION_MANAGE_USER
        ]);
        // đồng bộ file
        Permission::create([
            'id' => PERMISSION_SYNC_FILE_ID,
            'name' => PERMISSION_SYNC_FILE
        ]);
        // trình chạy file
        Permission::create([
            'id' => PERMISSION_PLAY_FILE_ID,
            'name' => PERMISSION_PLAY_FILE
        ]);
        // quản lý line
        Permission::create([
            'id' => PERMISSION_MANAGE_LINE_ID,
            'name' => PERMISSION_MANAGE_LINE
        ]);
        // quản lý department
        Permission::create([
            'id' => PERMISSION_DEPARTMENT_ID,
            'name' => PERMISSION_MANAGE_DEPARTMENT
        ]);
        // quản lý micropc
        Permission::create([
            'id' => PERMISSION_MANAGE_MICROPC_ID,
            'name' => PERMISSION_MANAGE_MICROPC
        ]);
        // quản lý pc điều khiển
        Permission::create([
            'id' => PERMISSION_MANAGE_PC_ID,
            'name' => PERMISSION_MANAGE_PC
        ]);
        // setting
        Permission::create([
            'id' => PERMISSION_SETTING_ID,
            'name' => PERMISSION_SETTING
        ]);

        // role
        $role_admin = Role::create([
            'id'   => ROLE_ADMIN_ID,
            'name' => USER_ROLE_ADMIN
        ]);
        $role_pe = Role::create([
            'id'   => ROLE_PE_ID,
            'name' => USER_ROLE_PE
        ]);
        $role_line_manager = Role::create([
            'id'   => ROLE_MANAGE_LINE_ID,
            'name' => USER_ROLE_MANAGE_LINE
        ]);

        // gán quyền
        $role_admin->givePermissionTo(Permission::all());
        $role_pe->givePermissionTo(PERMISSION_SYNC_FILE_ID);
        $role_line_manager->givePermissionTo(PERMISSION_PLAY_FILE_ID);

        // gán role cho user
        if ( env('MIX_ENV_MODE') === 'production') {
            // gán role cho user
            User::find(1)->assignRole(USER_ROLE_ADMIN);
            User::find(2)->assignRole(USER_ROLE_ADMIN);
            User::find(3)->assignRole(USER_ROLE_PE);
            User::find(4)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(5)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(6)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(7)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(8)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(9)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(10)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(11)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(12)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(13)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(14)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(15)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(16)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(17)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(18)->assignRole(USER_ROLE_MANAGE_LINE);
        } else {
            User::find(1)->assignRole(USER_ROLE_ADMIN);
            User::find(2)->assignRole(USER_ROLE_PE);
            User::find(3)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(4)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(5)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(6)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(7)->assignRole(USER_ROLE_MANAGE_LINE);
            User::find(8)->assignRole(USER_ROLE_MANAGE_LINE);
        }
    }
}
