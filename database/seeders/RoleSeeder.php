<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1 = Role::create(['name'=>'Admin']);
        $rol2 = Role::create(['name'=>'Supervisor']);
        $rol3 = Role::create(['name'=>'Empleado']);

        Permission::create(['name'=>'admin.pets.index'])->syncRoles([$rol1,$rol2,$rol3]);
        Permission::create(['name'=>'admin.pets.create'])->syncRoles([$rol1,$rol2,$rol3]);
        Permission::create(['name'=>'admin.pets.edit'])->syncRoles([$rol1,$rol2,$rol3]);
        Permission::create(['name'=>'admin.pets.destroy'])->syncRoles([$rol1,$rol2,$rol3]);

       
        
        //
    }
}
