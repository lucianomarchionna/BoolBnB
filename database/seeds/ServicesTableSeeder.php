<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [  
                'name' => 'WI-FI',
                'icon' => 'fas fa-wifi'
            ],
            [  
                'name' => 'Parcheggio',
                'icon' => 'fas fa-parking'
            ],
            [  
                'name' => 'Tv',
                'icon' => 'fas fa-tv'
            ],
            [  
                'name' => 'Kitchen',
                'icon' => 'fas fa-utensils'
            ],
            [  
                'name' => 'Dryer',
                'icon' => 'fas fa-wind'
            ],
            [  
                'name' => 'Air conditioner',
                'icon' => 'fas fa-fan'
            ],
            [  
                'name' => 'Pool',
                'icon' => 'fas fa-swimmer'
            ],
            [  
                'name' => 'Gym',
                'icon' => 'fas fa-dumbbell'
            ],
            [  
                'name' => 'Room service',
                'icon' => 'fas fa-tty'
            ]
        ];

        foreach($services as $service){
            $new_service = new Service();
            $new_service->name = $service['name'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
    }
    
}
