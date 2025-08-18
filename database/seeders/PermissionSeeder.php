<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();

        $permissions = [

            [
                'id' => 1,
                'display_name' => 'ইউজার তৈরী করা',
                'name' => 'can-create-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'display_name' => 'ইউজার আপডেট করা',
                'name' => 'can-edit-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'display_name' => 'ইউজার ডিলিট করা',
                'name' => 'can-delete-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'display_name' => 'ইউজার দেখা',
                'name' => 'can-view-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'display_name' => 'ইউজার ডিটেইলস দেখা',
                'name' => 'can-view-details-user',
                'guard_name' => 'web',
                'group_name' => 'User Management',
                'is_active' => true,
            ],
            [
                'id' => 6,
                'display_name' => 'রোল তৈরী করা',
                'name' => 'can-create-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 7,
                'display_name' => 'রোল আপডেট করা',
                'name' => 'can-edit-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 8,
                'display_name' => 'রোল ডিলিট করা',
                'name' => 'can-delete-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 9,
                'display_name' => 'রোল দেখা',
                'name' => 'can-view-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 10,
                'display_name' => 'রোল ডিটেইলস দেখা',
                'name' => 'can-view-details-role',
                'guard_name' => 'web',
                'group_name' => 'Role Management',
                'is_active' => true,
            ],
            [
                'id' => 11,
                'display_name' => 'পারমিশন তৈরী করা',
                'name' => 'can-create-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 12,
                'display_name' => 'পারমিশন আপডেট করা',
                'name' => 'can-edit-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 13,
                'display_name' => 'পারমিশন ডিলিট করা',
                'name' => 'can-delete-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 14,
                'display_name' => 'পারমিশন দেখা',
                'name' => 'can-view-permission',
                'guard_name' => 'web',
                'group_name' => 'Permission Management',
                'is_active' => true,
            ],
            [
                'id' => 15,
                'display_name' => 'কোম্পানি তৈরী করা',
                'name' => 'can-create-company',
                'guard_name' => 'web',
                'group_name' => 'Company Management',
                'is_active' => true,
            ],
            [
                'id' => 16,
                'display_name' => 'স্টুডেন্ট দেখা',
                'name' => 'can-view-student',
                'guard_name' => 'web',
                'group_name' => 'Student Management',
                'is_active' => true,
            ],
            [
                'id' => 17,
                'display_name' => 'স্টুডেন্ট তৈরী করা',
                'name' => 'can-create-student',
                'guard_name' => 'web',
                'group_name' => 'Student Management',
                'is_active' => true,
            ],
            [
                'id' => 18,
                'display_name' => 'স্টুডেন্ট আপডেট করা',
                'name' => 'can-edit-student',
                'guard_name' => 'web',
                'group_name' => 'Student Management',
                'is_active' => true,
            ],
            [
                'id' => 19,
                'display_name' => 'স্টুডেন্ট ডিলিট করা',
                'name' => 'can-delete-student',
                'guard_name' => 'web',
                'group_name' => 'Student Management',
                'is_active' => true,
            ],
            [
                'id' => 20,
                'display_name' => 'স্টুডেন্ট ডিটেইলস দেখা',
                'name' => 'can-view-details-student',
                'guard_name' => 'web',
                'group_name' => 'Student Management',
                'is_active' => true,
            ],
            [
                'id' => 21,
                'display_name' => 'ডিপার্টমেন্ট দেখা',
                'name' => 'can-view-department',
                'guard_name' => 'web',
                'group_name' => 'Department Management',
                'is_active' => true,
            ],
            [
                'id' => 22,
                'display_name' => 'ডিপার্টমেন্ট তৈরী করা',
                'name' => 'can-create-department',
                'guard_name' => 'web',
                'group_name' => 'Department Management',
                'is_active' => true,
            ],
            [
                'id' => 23,
                'display_name' => 'ডিপার্টমেন্ট আপডেট করা',
                'name' => 'can-edit-department',
                'guard_name' => 'web',
                'group_name' => 'Department Management',
                'is_active' => true,
            ],
            [
                'id' => 24,
                'display_name' => 'ডিপার্টমেন্ট ডিলিট করা',
                'name' => 'can-delete-department',
                'guard_name' => 'web',
                'group_name' => 'Department Management',
                'is_active' => true,
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
