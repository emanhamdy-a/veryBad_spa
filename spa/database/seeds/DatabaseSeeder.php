<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Customer;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
      factory('App\User', 20)->create();
      factory('App\Customer', 100)->create();
    }
}


