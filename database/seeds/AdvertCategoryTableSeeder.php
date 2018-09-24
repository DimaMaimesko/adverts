<?php

use Illuminate\Database\Seeder;
use App\Models\Adverts\Category;
class AdvertCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 10)->create()->each(function(Category $region) {
            $region->children()->saveMany(factory(Category::class, random_int(0, 5))->create()->each(function(Category $region) {
                $region->children()->saveMany(factory(Category::class, random_int(0, 5))->create()->each(function(Category $region) {
                     $region->children()->saveMany(factory(Category::class, random_int(0, 5))->make());
                }));
            }));
        });
    }
}
