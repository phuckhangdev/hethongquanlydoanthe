<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DoankhoatosTableSeeder::class,
            ChidoansTableSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            UsersTableSeeder::class
        ]);
        // $this->call(DoankhoatosTableSeeder::class);
        // $this->call(ChidoansTableSeeder::class);
        // $this->call(PermissionTableSeeder::class);
        // $this->call(RoleTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
