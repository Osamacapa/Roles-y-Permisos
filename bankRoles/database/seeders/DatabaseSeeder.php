<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Controllers;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this -> call([
            PermissionSeeder::class,
        ]);
        User::factory(2)-> create();
        $admin = User::find(1);
        $admin->assignRole('admin');
        $cashier = User::find(2);
        $cashier->assignRole('cashier');
    }
}
