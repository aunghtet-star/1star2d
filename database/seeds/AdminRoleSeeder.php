<?php

namespace Database\Seeders;

use App\AdminUser;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Database\Seeders\AdminRoleSeeder;
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

         // firstOrCreate permissions
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
 
         // firstOrCreate roles and assign existing permissions
         $role1 = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'adminuser']);
         $role1->givePermissionTo('view_admin');
         $role1->givePermissionTo('create_admin');
         $role1->givePermissionTo('edit_admin');
         $role1->givePermissionTo('delete_admin');
         $role1->givePermissionTo('view_role');
         $role1->givePermissionTo('create_role');
         $role1->givePermissionTo('edit_role');
         $role1->givePermissionTo('delete_role');
         $role1->givePermissionTo('view_permission');
         $role1->givePermissionTo('create_permission');
         $role1->givePermissionTo('edit_permission');
         $role1->givePermissionTo('delete_permission');
         $role1->givePermissionTo('view_wallet');
         $role1->givePermissionTo('add_wallet');
         // gets all permissions via Gate::before rule; see AuthServiceProvider
 
         // firstOrCreate demo users
         $user = AdminUser::where('id',1)->first();
         $user->assignRole($role1);
    }
}
