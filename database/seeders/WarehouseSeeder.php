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
        $Warehouse_names = ['omar','2','3','4'];
        for($i=0;$i<4;$i++)
        {
            Warehouse::create([
                'WareHousename' => $Warehouse_names[$i],
                'username'=>'omar',
                'password'=>'123456'
            ]);
        }
    }
}
