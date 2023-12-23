<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Schema::disableForeignKeyConstraints();
        Medicine::truncate();
        $scientific_name = ['Amoxicillin','Paracetamol','Alverine citrate','Brobanolol'];
        $commercial_name = ['Clafomas','Uniadol','spacemavir','Underalmade'];
        $category_id = DB::table('categories')->pluck('id');
        $manufacture_company = ['Ibn Al-Zahr','Uni Pharma','Tamiko','City Pharma'];
        $quantity_available = ['20','25','30','40'];
        $expiration_date = ['2024-5-8','2024-5-2','2024-3-5','2024-9-6'];
        $price = ['500','800','300','950'];
        $warehouse = DB::table('warehouses')->pluck('id');
        $faker = Factory::create();
        for($i=0;$i<4;$i++)
        {
            $randomElement = $faker->randomElement($warehouse);
            Medicine::create([
                'scientific_name' => $scientific_name[$i],
                'commercial_name' => $commercial_name[$i],
                'category_id'=>$category_id[$i],
                'manufacture_company'=>$manufacture_company[$i],
                'quantity_available'=>$quantity_available[$i],
                'expiration_date'=>$expiration_date[$i],
                'price'=>$price[$i],
                'warehouse_id'=>$randomElement
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
