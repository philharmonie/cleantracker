<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirebaseTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $json = file_get_contents(base_path('backup.json'));
        $data = json_decode($json, true);
        $tasks = $data['__collections__']['tasks'];

        Task::truncate();

        foreach ($tasks as $task) {
            Task::create([
                'user_id' => User::where('name', $task['wer'])->first()->id,
                'date' => date('Y-m-d', $task['timestamp']['value']['_seconds']),
                'name' => $task['was'],
                'points' => isset($task['rating']) ? $task['rating'] : 1,
            ]);
        }
    }
}
