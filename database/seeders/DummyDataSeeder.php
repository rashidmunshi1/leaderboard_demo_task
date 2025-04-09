<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user) {
            for ($i = 0; $i < rand(5, 30); $i++) {
                $date = now()->subDays(rand(0, 60));
                Activity::create([
                    'user_id' => $user->id,
                    'completed_at' => $date,
                ]);
            }
        });
    }
}
