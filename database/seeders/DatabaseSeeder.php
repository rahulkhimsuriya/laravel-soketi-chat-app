<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $rahul = User::first();

        User::query()
            ->where('id', '!=', $rahul->id)
            ->get()
            ->each(function ($user) use ($rahul) {
                Chat::factory(10)
                    ->sequence(
                        [
                            'sender_id' => $rahul->id,
                            'receiver_id' => $user->id
                        ],
                        [
                            'sender_id' => $user->id,
                            'receiver_id' => $rahul->id
                        ]
                    )
                    ->create();
            });
    }
}
