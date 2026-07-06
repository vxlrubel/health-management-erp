<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        $subjects = [
            'Care plan update for client #1',
            'Schedule change request',
            'Holiday approval discussion',
            'Training session reminder',
            'Office supplies order',
        ];

        foreach ($subjects as $subject) {
            $conversation = Conversation::firstOrCreate(
                ['subject' => $subject],
                ['uuid' => \Illuminate\Support\Str::uuid()]
            );

            $numMessages = rand(2, 5);
            for ($i = 0; $i < $numMessages; $i++) {
                $sender = $users->random();
                Message::firstOrCreate(
                    ['conversation_id' => $conversation->id, 'body' => $subject . ' - message ' . ($i + 1)],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'sender_id' => $sender->id,
                        'body' => $faker->paragraph(),
                        'read_at' => $i < $numMessages - 1 ? now()->subMinutes(rand(1, 60)) : null,
                        'created_at' => now()->subHours($numMessages - $i),
                        'updated_at' => now()->subHours($numMessages - $i),
                    ]
                );
            }
        }

        $this->command->info('Conversations and messages seeded successfully.');
    }
}
