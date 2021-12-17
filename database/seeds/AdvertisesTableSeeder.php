<?php

use App\Advertise;
use Illuminate\Database\Seeder;

class AdvertisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $advertises = [
            [
                'name'=>'Bronze',
                'price'=>2.99,
                'duration'=>24,
            ],
            [
                'name'=>'Silver',
                'price'=>5.99,
                'duration'=>72,
            ],
            [
                'name'=>'Gold',
                'price'=>9.99,
                'duration'=>144,
            ],
        ];

        foreach($advertises as $advertise){
            $new_advertise = new Advertise();
            $new_advertise->name = $advertise['name'];
            $new_advertise->price = $advertise['price'];
            $new_advertise->duration = $advertise['duration'];
            $new_advertise->save();
        }
    }
}
