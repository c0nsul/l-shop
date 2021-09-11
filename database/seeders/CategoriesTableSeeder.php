<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Mobile phones',
                'code' => 'mobiles',
                'description' => 'In this section you will find the most popular mobile phones at great prices! ',
                'image' => 'categories/mobile.jpg',
            ],
            [
                'name' => 'Portable technology',
                'code' => 'portable',
                'description' => 'Section with portable equipment. ',
                'image' => 'categories/portable.jpg',
            ],
            [
                'name' => 'Бытовая техника',
                'code' => 'appliances',
                'description' => 'Section with household appliances ',
                'image' => 'categories/appliance.jpg',
            ],
        ]);
    }
}
