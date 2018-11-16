<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CaptochucsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('captochucs')->insert([
                'tencaptochuc' => $faker->unique()->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
