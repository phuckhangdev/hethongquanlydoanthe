<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HoatdongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('hoatdongs')->insert([
                'tenhoatdong' => $faker->name,
                // $values = $faker->numberBetween(2006, 2018),
                // 'namhoc' => ($values + ' - ' + ($values + 1)),
                'namhoc' => $faker->randomElement($array = array ('2016 - 2017','2017 - 2018','2018 - 2019')),
                'hocky' => $faker->numberBetween(1,2),
                'thoigian' => Carbon::now(),
                'diadiem' => $faker->address,
                'captochuc_id' => $faker->numberBetween(1,10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
