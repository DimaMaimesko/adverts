<?php

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionsTableSeeder extends Seeder
{

    public function run()
    {
        $level_0_sort = 10;
        $level_1_sort = random_int(3, 10);
        $level_2_sort = random_int(0, 10);
        $level_3_sort = random_int(0, 10);

        for ($i = 0; $i <= $level_0_sort; $i++){
         factory(Region::class)->create(['sort' => $i]);
        }
        $level_0_regions = Region::where('depth',0)->get();
        foreach ($level_0_regions as $key => $region){
            for ($i = 0; $i <= $level_1_sort; $i++){
                factory(Region::class)->create(['parent_id' => $region->id,'sort' => $i,'depth' => 1]);
            }
        }
        $level_1_regions = Region::where('depth',1)->get();
        foreach ($level_1_regions as $key => $region){
            for ($i = 0; $i <= $level_2_sort; $i++){
                factory(Region::class)->create(['parent_id' => $region->id,'sort' => $i,'depth' => 2]);
            }
        }
        $level_2_regions = Region::where('depth',2)->get();
        foreach ($level_2_regions as $key => $region){
            for ($i = 0; $i <= $level_3_sort; $i++){
                factory(Region::class)->create(['parent_id' => $region->id,'sort' => $i,'depth' => 3]);
            }
        }


//        factory(Region::class, 10)->create()->each(function(Region $region) {
//            $region->children()->saveMany(factory(Region::class, random_int(3, 10))->create()->each(function(Region $region) {
//                $region->children()->saveMany(factory(Region::class, random_int(3, 10))->create()->each(function(Region $region) {
//                     $region->children()->saveMany(factory(Region::class, random_int(3, 10))->make());
//                }));
//            }));
//        });
    }
}
