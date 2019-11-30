<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        /*
        for($i = 1; $i <= 50; $i++) {
            DB::table('users')->insert([
                'id' => $faker->unique()->randomNumber($nbDigits = 8),
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'email_verified_at' => now(),
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        */

        /*
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'alvinbintang',
            'email' => 'alvin@alvin',
            'email_verified_at' => now(),
            'phone_number' => '089672747092',
            'password' => 'alvinbintang',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        */

        DB::table('location')->insert([
            'id' => 1,
            'address' => 'Kepuh RT01/RW01 Tegaltirto',
            'districts' => 'Berbah',
            'city_id' => 'Sleman',
            'province_id_id' => 'DIY',
            'kodepos' => 55573,
        ]);

        DB::table('category')->insert([
            'category_id' => 1,
            'explanation' => 'makanan dan minuman',
        ]);

        DB::table('category')->insert([
            'category_id' => 2,
            'explanation' => 'elektronik',
        ]);

        for($i = 1; $i <= 5; $i++) {
            DB::table('item')->insert([
                'name' => $faker->city,
                'description' => $faker->word,
                'stock' => 10,
                'purchasing_price' => 12000,
                'selling_price' => 19000,
                'weight' => 200,
                'category_id' => 1,
                'id' => 1,
            ]);
        }
        //run: php artisan db:seed --class=DatabaseSeeder
    }
}
