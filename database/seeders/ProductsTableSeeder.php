<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB :: table ('products') -> insert ([
            [
                'name' => 'iPhone X 64GB',
                'code' => 'iphone_x_64',
                'description' => 'Great advanced phone with 64 gb memory',
                'price' => '71990',
                'category_id' => 1,
                'image' => 'products/iphone_x.jpg',
            ],
            [
                'name' => 'iPhone X 256GB',
                'code' => 'iphone_x_256',
                'description' => 'Excellent advanced phone with 256 gb memory',
                'price' => '89990',
                'category_id' => 1,
                'image' => 'products/iphone_x_silver.jpg',
            ],
            [
                'name' => 'HTC One S',
                'code' => 'htc_one_s',
                'description' => 'Why pay for excess? Legendary HTC One S ',
                'price' => '12490',
                'category_id' => 1,
                'image' => 'products/htc_one_s.png',
            ],
            [
                'name' => 'iPhone 5SE',
                'code' => 'iphone_5se',
                'description' => 'Great Classic iPhone',
                'price' => '17221',
                'category_id' => 1,
                'image' => 'products/iphone_5.jpg',
            ],
            [
                'name' => 'Beats Audio Headphones',
                'code' => 'beats_audio',
                'description' => 'Great sound from Dr. Dre ',
                'price' => '20221',
                'category_id' => 2,
                'image' => 'products/beats.jpg',
            ],
            [
                'name' => 'GoPro Camera',
                'code' => 'gopro',
                'description' => 'Capture your highlights with this camera',
                'price' => '12000',
                'category_id' => 2,
                'image' => 'products/gopro.jpg',
            ],
            [
                'name' => 'Panasonic HC-V770 Camera',
                'code' => 'panasonic_hc-v770',
                'description' => 'Serious video shooting requires a serious camera. Panasonic HC-V770 is the best choice for these purposes! ',
                'price' => '27900',
                'category_id' => 2,
                'image' => 'products/video_panasonic.jpg',
            ],
            [
                'name' => 'DeLongi Coffee Machine',
                'code' => 'delongi',
                'description' => 'A Good Morning Starts With Good Coffee!',
                'price' => '25200',
                'category_id' => 3,
                'image' => 'products/delongi.jpg',
            ],
            [
                'name' => 'Haier Fridge',
                'code' => 'haier',
                'description' => 'Big fridge for a big family!',
                'price' => '40200',
                'category_id' => 3,
                'image' => 'products/haier.jpg',
            ],
            [
                'name' => 'Moulinex Blender',
                'code' => 'moulinex',
                'description' => 'For the boldest ideas',
                'price' => '4200',
                'category_id' => 3,
                'image' => 'products/moulinex.jpg',
            ],
            [
                'name' => 'Bosch Meat Grinder',
                'code' => 'bosch',
                'description' => 'Do you like homemade cutlets? You should definitely take a look at this meat grinder! ',
                'price' => '9200',
                'category_id' => 3,
                'image' => 'products/bosch.jpg',
            ],
        ]);
    }
}
