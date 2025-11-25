<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@ntc.local'],
            [
                'name' => 'NTC Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Comment ArticleSeeder sementara karena Faker issue di production
        // Uncomment jika Faker sudah terinstall dengan benar
        // $this->call([
        //     ArticleSeeder::class,
        // ]);
    }
}
