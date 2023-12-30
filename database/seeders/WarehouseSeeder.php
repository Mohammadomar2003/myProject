<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Warehouse::truncate();
        Schema::enableForeignKeyConstraints();
        $Warehouse_names = ['omar','anas','abd','masa','maya'];
        $username = ['omar','anas','abd','masa','maya'];
        for($i=0;$i<5;$i++)
        {
            Warehouse::create([
                'WareHouse_name' => $Warehouse_names[$i],
                'username'=>$username[$i],
                'password'=>'123456'
            ]);
        }
    }
}
