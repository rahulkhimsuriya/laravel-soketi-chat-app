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
        $john = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);

        User::factory(10)->create()
            ->each(function ($user) use ($john) {
                Chat::factory(10)
                    ->sequence(
                        [
                            'sender_id' => $john->id,
                            'receiver_id' => $user->id
                        ],
                        [
                            'sender_id' => $user->id,
                            'receiver_id' => $john->id
                        ]
                    )
                    ->create();
            });
    }
}
