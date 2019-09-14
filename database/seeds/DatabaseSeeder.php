<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('UserTableSeeder');

        $this->command->info('Таблица пользователей загружена.');
    }
}

class UserTableSeeder extends Seeder {

    public function run()
    {
    //   DB::table('users')->delete();
  
      User::create([
          'name'     => 'admin',
          'email'    => 'admin@admin.ru',
          'password' => 'admin'
        ]);
    }
  
  }