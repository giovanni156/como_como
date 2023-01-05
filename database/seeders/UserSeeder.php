<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user2 = User::create([
            'name' => 'María del Pilar',
            'last_name' => 'Pozos Parra',
            'email' => 'maripozos@gmail.com',
            'password' => Hash::make('12345')
        ]);
        $user2->nutritionist()->create([
            'professional_license' => 'RTTERVA1244',
            'user_id' => $user2->id
        ]);
        $user2->syncRoles(['nutritionist']);

        $user1 = User::create([
            'name' => 'Giovanni',
            'last_name' => 'Trejo',
            'email' => 'gtaa7x@gmail.com',
            'identifier' => 'TEAG931208HPLRBV07',
            'password' => Hash::make('12345'),
            'email_verified_at' => Carbon::now()
        ]);
        $user1->patient()->create([
            'date_of_birth' => Carbon::parse('1993-12-08'),
            'user_id' => $user1->id,
            'nutritionist_id' => $user2->id
        ]);
        $user1->syncRoles(['patient']);



        $user3 = User::create([
            'name' => 'Admin',
            'last_name' => 'One',
            'email' => 'admin1@comocomo.com',
            'password' => Hash::make('12345')
        ]);
        $user3->syncRoles(['admin']);
    }
}
