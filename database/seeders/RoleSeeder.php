<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds_
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);
        Role::create(['name' => 'user']);
        $permissions = [
            [
                'group_name' => 'Global',
                'permissions' => [
                    'dashboard_manage',
                    'site_setting_manage',
                    'code_setting_manage',
                    'page_setting_manage',
                ]
            ],
            [
                'group_name' => 'Commands',
                'permissions' => [
                    'commands_manage',
                    'command_cache_clear',
                    'command_config_clear',
                    'command_route_clear',
                    'command_optimize',
                    'command_migrate',
                    'command_migrate_fresh',
                    'command_migrate_fresh_seed',
                ]
            ],
            [
                'group_name' => 'Roles',
                'permissions' => [
                    'role_manage',
                    'role_list',
                    'role_view',
                    'role_create',
                    'role_update',
                    'role_delete',
                ]
            ],
            [
                'group_name' => 'Permission',
                'permissions' => [
                    'permission_manage',
                    'permission_list',
                    'permission_view',
                    'permission_update',
                    'permission_delete',
                    'permission_create',

                ]
            ],
            [
                'group_name' => 'Admin',
                'permissions' => [
                    'admin_manage',
                    'admin_list',
                    'admin_view',
                    'admin_update',
                    'admin_delete',
                    'admin_create',
                ]
            ],
            [
                'group_name' => 'User',
                'permissions' => [
                    'user_manage',
                    'user_list',
                    'user_view',
                    'user_update',
                    'user_delete',
                    'user_create',
                ]
            ],
            [
                'group_name' => 'Brand',
                'permissions' => [
                    'brand_manage',
                    'brand_list',
                    'brand_view',
                    'brand_update',
                    'brand_delete',
                    'brand_create',
                ]
            ],
            [
                'group_name' => 'Categories',
                'permissions' => [
                    'category_manage',
                    'category_list',
                    'category_view',
                    'category_update',
                    'category_delete',
                    'category_create',
                ]
            ],
            [
                'group_name' => 'Products',
                'permissions' => [
                    'product_manage',
                    'product_list',
                    'product_view',
                    'product_update',
                    'product_delete',
                    'product_create',
                ]
            ],
            [
                'group_name' => 'Orders',
                'permissions' => [
                    'order_manage',
                    'order_list',
                    'order_view',
                    'order_update',
                    'order_delete',
                    'order_create',
                ]
            ],
            [
                'group_name' => 'Sliders',
                'permissions' => [
                    'slider_manage',
                    'slider_list',
                    'slider_view',
                    'slider_update',
                    'slider_delete',
                    'slider_create',
                ]
            ],
            [
                'group_name' => 'Menus',
                'permissions' => [
                    'menu_manage',
                    'menu_list',
                    'menu_view',
                    'menu_update',
                    'menu_delete',
                    'menu_create',
                ]
            ],
            [
                'group_name' => 'DeliveryZone',
                'permissions' => [
                    'delivery_zone_manage',
                    'delivery_zone_list',
                    'delivery_zone_view',
                    'delivery_zone_update',
                    'delivery_zone_delete',
                    'delivery_zone_create',
                ]
            ],
            [
                'group_name' => 'PaymentMethod',
                'permissions' => [
                    'payment_method_manage',
                    'payment_method_list',
                    'payment_method_view',
                    'payment_method_update',
                    'payment_method_delete',
                    'payment_method_create',
                ]
            ],

        ];

        for ($i = 0;$i<count($permissions);$i++){
            $permissions_group = $permissions[$i]['group_name'];
            for ($j = 0;$j<count($permissions[$i]['permissions']);$j++){
                //Admin guard Permisson
                $super_permission =  Permission::create(['name'=>$permissions[$i]['permissions'][$j],'group_name'=>$permissions_group]);
                $superAdmin->givePermissionTo($super_permission);
                $super_permission->assignRole($superAdmin);

            }

        }
    }
}
