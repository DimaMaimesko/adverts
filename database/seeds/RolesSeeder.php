<?php

    use Spatie\Permission\Models\Role;
	use App\Models\User;
	use Illuminate\Database\Seeder;
	use Spatie\Permission\Models\Permission;

	class RolesSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

	        // Reset cached roles and permissions
	        app()['cache']->forget('spatie.permission.cache');
	        // create permissions

	        // users
	        Permission::create(['name' => 'add users']);
	        Permission::create(['name' => 'edit users']);
	        Permission::create(['name' => 'delete users']);
	        Permission::create(['name' => 'active users']);

	        // admins
	        Permission::create(['name' => 'add admins']);
	        Permission::create(['name' => 'edit admins']);
	        Permission::create(['name' => 'delete admins']);
	        Permission::create(['name' => 'active admins']);

	        // settings
	        Permission::create(['name' => 'add settings']);
	        Permission::create(['name' => 'edit settings']);
	        Permission::create(['name' => 'delete settings']);

	        Permission::create(['name' => 'manage languages']);
	        Permission::create(['name' => 'manage translations']);
	        Permission::create(['name' => 'publish translations']);

	        Permission::create(['name' => 'pages']);
	        Permission::create(['name' => 'pages-template']);
	        Permission::create(['name' => 'seo']);

	        Permission::create(['name' => 'set roles']);
	        Permission::create(['name' => 'access-admin']);
	        Permission::create(['name' => 'manage-own-advert']);
	        Permission::create(['name' => 'moderate-advert']);
	        Permission::create(['name' => 'set roles']);

	        $role = Role::create(['name' => User::SUPERADMIN]);
	        $role->givePermissionTo(Permission::all());

	        Role::create(['name' => User::MODERATOR]);
	        Role::create(['name' => User::USER]);
        }
    }
