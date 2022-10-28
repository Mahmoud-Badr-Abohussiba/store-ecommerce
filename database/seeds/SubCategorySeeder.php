<?php

use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category::class, 3)->create(
            ['parent_id'=> $this->getRandomParentId()]
        );
    }

    private function getRandomParentId(){
        if(\App\Models\Category::parent()->count()==0){
            factory(\App\Models\Category::class, 1)->create();
        }

       return  \App\Models\Category::inRandomOrder()->first();
    }
}
