<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Alex Admin',
            'email' => 'admin@bugspring.test',
            'password' => Hash::make('secret'),
        ]);


        $this->call(ProjectSeeder::class);
    }
}
