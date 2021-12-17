<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 5; $i++) {
            $new_user = new User();
            $new_user->name = $faker->firstNameMale();
            $new_user->surname = $faker->lastName();
            $new_user->email = $faker->email();
            $new_user->password = 'password123';
            $new_user->save();
        }
    }
}
