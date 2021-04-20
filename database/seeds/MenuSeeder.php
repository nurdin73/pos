<?php

namespace Database\Seeders;

use App\Models\ChildSubMenu;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'sub_menu' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-speedometer',
                        'url' => 'dashboardAdmin', // route name
                        'child_sub_menu' => [] 
                    ]
                ]
            ],
            [
                'name' => 'Managements',
                'sub_menu' => [
                    [
                        'name' => 'Barang',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-storage',
                        'url' => 'managementBarang', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Kategori Barang',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-excerpt',
                        'url' => 'managementKategori', // route name
                        'child_sub_menu' => [] 
                    ],
                    // [
                    //     'name' => 'Return barang',
                    //     'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-loop',
                    //     'url' => 'returnBarang', // route name
                    //     'child_sub_menu' => [] 
                    // ],
                    [
                        'name' => 'Suplier',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-truck',
                        'url' => 'managementSuplier', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Cabang',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-industry',
                        'url' => 'managementCabang', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Management Stok',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-equalizer',
                        'url' => 'managementStok', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Transaksi',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-chart',
                        'url' => '#', // route name
                        'child_sub_menu' => [
                            [
                                'name' => 'List Transaksi',
                                'url' => 'listTransaksi'
                            ],
                            [
                                'name' => 'Tambah Transaksi',
                                'url' => 'managementTransaksi'
                            ],
                        ] 
                    ],
                    [
                        'name' => 'Pelanggan',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-people',
                        'url' => 'managementPelanggan', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Kasbon',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-wallet',
                        'url' => 'managementKasbon', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Pajak',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-fax',
                        'url' => 'pajakUniversal', // route name
                        'child_sub_menu' => [] 
                    ],
                    // [
                    //     'name' => 'Loyality Program',
                    //     'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-dollar',
                    //     'url' => 'loyalityProgram', // route name
                    //     'child_sub_menu' => [] 
                    // ],
                    [
                        'name' => 'Management Staff',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-contact',
                        'url' => 'settingManagementStaff', // route name
                        'child_sub_menu' => [] 
                    ],
                ]
            ],
            [
                'name' => 'Reports',
                'sub_menu' => [
                    [
                        'name' => 'Laporan',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-save',
                        'url' => '#', // route name
                        'child_sub_menu' => [
                            [
                                'name' => 'Umum',
                                'url' => 'reportUmum'
                            ],
                            [
                                'name' => 'Transaksi',
                                'url' => 'reportTransaksi'
                            ],
                            [
                                'name' => 'Penjualan Barang',
                                'url' => 'reportPenjualan'
                            ],
                            [
                                'name' => 'Pembelian Barang',
                                'url' => 'reportPembelian'
                            ],
                        ] 
                    ],
                    [
                        'name' => 'Barang',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-storage',
                        'url' => 'reportBarang', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Modal',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-swap-horizontal',
                        'url' => 'reportModal', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Pajak',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-fax',
                        'url' => 'reportPajak', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Kasbon',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-wallet',
                        'url' => 'reportKasbon', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Pelanggan',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-people',
                        'url' => 'reportPelanggan', // route name
                        'child_sub_menu' => [] 
                    ],
                ]
            ],
            [
                'name' => 'Settings',
                'sub_menu' => [
                    [
                        'name' => 'Jabatan',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-check-circle',
                        'url' => 'settingRoles', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Profile',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-user',
                        'url' => 'settingProfile', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Toko',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-house',
                        'url' => 'settingToko', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Akses user',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-lock-locked',
                        'url' => 'settingAccess', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Database',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-storage',
                        'url' => 'settingDatabase', // route name
                        'child_sub_menu' => [] 
                    ],
                    [
                        'name' => 'Printer Settings',
                        'icon' => 'vendors/@coreui/icons/svg/free.svg#cil-print',
                        'url' => 'printerSettings', // route name
                        'child_sub_menu' => [] 
                    ],
                ]   
            ]
        ];

        foreach ($menus as $menu) {
            $createMenu = Menu::create([
                'name' => $menu['name']
            ]);
            if(count($menu['sub_menu']) > 0) {
                foreach ($menu['sub_menu'] as $submenu) {
                    $createSubMenu = SubMenu::create([
                        'menu_id'   => $createMenu->id,
                        'name'      => $submenu['name'],
                        'url'       => $submenu['url'],
                        'icon'      => $submenu['icon']
                    ]);
                    if(count($submenu['child_sub_menu']) > 0) {
                        foreach ($submenu['child_sub_menu'] as $childSubMenu) {
                            $createChildSubMenu = ChildSubMenu::create([
                                'sub_menu_id'   => $createSubMenu->id,
                                'name'      => $childSubMenu['name'],
                                'url'       => $childSubMenu['url'],
                            ]);
                        }
                    }
                }
            }
        }
    }
}
