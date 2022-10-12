<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\Models\Admin::create([
           'name'=>'Mahmoud Badr',
           'email'=>'admin@app.com',
           'password'=>bcrypt('12345678'),
       ]);
    }
}
