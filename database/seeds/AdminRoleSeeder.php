<?php

namespace Database\Seeders;

use App\AdminUser;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
         app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //firstOrCreate permissions
         Permission::firstOrCreate(['name' => 'view_admin', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'create_admin', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'edit_admin', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'delete_admin', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'view_role', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'create_role', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'edit_role', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'delete_role', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'view_permission', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'create_permission', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'edit_permission', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'delete_permission', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'view_wallet', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'add_wallet', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'substract_wallet', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'two', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'dubai_two', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'dubai_two_overview', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'three', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'two_overview', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'three_overview', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'two_kyon', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'three_kyon', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'brake', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'fake_number', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'real_number', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'show_hide', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'pout', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'wallet_history', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'bet_history', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'only_brake', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'dubai_two_kyon', 'guard_name' => 'adminuser']);

         Permission::firstOrCreate(['name' => 'master', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'agent', 'guard_name' => 'adminuser']);
         Permission::firstOrCreate(['name' => 'user', 'guard_name' => 'adminuser']);

         // firstOrCreate roles and assign existing permissions
         $admin_role = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'adminuser']);
         $admin_role->givePermissionTo('view_admin');
         //$admin_role->givePermissionTo('create_admin');
         $admin_role->givePermissionTo('edit_admin');
         //$admin_role->givePermissionTo('delete_admin');
         $admin_role->givePermissionTo('view_role');
         $admin_role->givePermissionTo('create_role');
         $admin_role->givePermissionTo('edit_role');
         $admin_role->givePermissionTo('delete_role');
         $admin_role->givePermissionTo('view_permission');
         $admin_role->givePermissionTo('create_permission');
         $admin_role->givePermissionTo('edit_permission');
         $admin_role->givePermissionTo('delete_permission');
         $admin_role->givePermissionTo('view_wallet');
         $admin_role->givePermissionTo('add_wallet');
         $admin_role->givePermissionTo('substract_wallet');
         $admin_role->givePermissionTo('two');
         $admin_role->givePermissionTo('three');
         $admin_role->givePermissionTo('two_overview');
         $admin_role->givePermissionTo('three_overview');
         $admin_role->givePermissionTo('two_kyon');
         $admin_role->givePermissionTo('three_kyon');
         $admin_role->givePermissionTo('brake');
         $admin_role->givePermissionTo('fake_number');
         $admin_role->givePermissionTo('real_number');
         $admin_role->givePermissionTo('show_hide');
         $admin_role->givePermissionTo('pout');
         $admin_role->givePermissionTo('wallet_history');
         $admin_role->givePermissionTo('bet_history');
         $admin_role->givePermissionTo('master');
         $admin_role->givePermissionTo('dubai_two');
         $admin_role->givePermissionTo('dubai_two_overview');
         $admin_role->givePermissionTo('only_brake');
         $admin_role->givePermissionTo('dubai_two_kyon');
         // gets all permissions via Gate::before rule; see AuthServiceProvider

         $master_role = Role::firstOrCreate(['name' => 'Master', 'guard_name' => 'adminuser']);
         $master_role->givePermissionTo('view_wallet');
         $master_role->givePermissionTo('add_wallet');
         $master_role->givePermissionTo('substract_wallet');
         $master_role->givePermissionTo('agent');
         $master_role->givePermissionTo('wallet_history');

         $agent_role = Role::firstOrCreate(['name' => 'Agent', 'guard_name' => 'adminuser']);
         $agent_role->givePermissionTo('view_wallet');
         $agent_role->givePermissionTo('add_wallet');
         $agent_role->givePermissionTo('substract_wallet');
         $agent_role->givePermissionTo('user');
         $agent_role->givePermissionTo('wallet_history');
         $agent_role->givePermissionTo('two');
         $agent_role->givePermissionTo('three');
         $agent_role->givePermissionTo('dubai_two');

         // firstOrCreate demo users

         $user = AdminUser::create([
             'name' => 'admin',
             'phone' => '09969861379',
             'password' => Hash::make('password')
         ]);
         $user->assignRole($admin_role);
    }
}
