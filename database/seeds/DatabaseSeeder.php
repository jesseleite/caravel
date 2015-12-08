<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        // Temporary Seeds?
            factory(App\Product::class, 24)->create();
            factory(App\Models\Newsletter::class, 5)->create();

        Model::reguard();
    }
}
