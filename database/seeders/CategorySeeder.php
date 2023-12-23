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
        $category_names = ['Infections','Painkillers','Digestives','Hearty'];
        for($i=0;$i<4;$i++)
        {
            Category::query()->create([
                'name' => $category_names[$i],
            ]);
        }
    }
}
