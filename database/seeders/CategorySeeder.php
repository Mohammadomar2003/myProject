<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();
        $category_names = ['Pain Killers','Inflammation','Immunomodulatory  Medications','Dermatological  Medications','Hormonedisorders  Medications'];
        for($i=0;$i<5;$i++)
        {
            Category::query()->create([
                'name' => $category_names[$i],
            ]);
        }
    }
}
