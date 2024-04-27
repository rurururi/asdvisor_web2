<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CareDecisionTopic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Lanz Del Rosario',
            'email' => 'lanz@asdvisorph.com',
            'account_level' => 'Administrator',
            'password' => Hash::make('12345678'),
            'image' => NULL
        ]);

        $doctor = \App\Models\User::factory()->create([
            'name' => 'Lanz Del Rosario',
            'email' => 'lanz+doctor@asdvisorph.com',
            'account_level' => 'Doctor',
            'password' => Hash::make('12345678'),
            'image' => NULL
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Lanz Del Rosario',
            'email' => 'lanz+parent@asdvisorph.com',
            'account_level' => 'Parents',
            'password' => Hash::make('12345678'),
            'image' => NULL
        ]);

        // $question = [];

        for($i = 0; $i < 3; $i++) {
            \App\Models\Category::factory()->create(['name' => 'Category ' . ($i + 1)]);
        }

        // $topic = \App\Models\Topic::factory()->create([
        //     'name' => 'What is love?',
        //     'doctor_id' => $doctor->id
        // ]);
        
        // for($i = 0; $i < 5; $i++) {
        //     $question[] = \App\Models\DoctorQuestion::factory()->create([
        //         'topic_id' => $topic->id,
        //         'doctor_id' => $doctor->id,
        //         'question' => 'Example Question #'.($i+1),
        //         'sort' => $i + 1
        //     ]);
        // }
        
        // $answer = [
        //     ["Yes", "Yes", "Yes", "Yes", "Yes"], 
        //     // ["Yes", "Yes", "Yes", "Yes", "No"], 
        //     // ["Yes", "Yes", "Yes", "No", "Yes"], 
        //     // ["Yes", "Yes", "Yes", "No", "No"], 
        //     // ["Yes", "Yes", "No", "Yes", "Yes"], 
        //     // ["Yes", "Yes", "No", "Yes", "No"], 
        //     // ["Yes", "Yes", "No", "No", "Yes"], 
        //     // ["Yes", "Yes", "No", "No", "No"], 
        //     // ["Yes", "No", "Yes", "Yes", "Yes"], 
        //     // ["Yes", "No", "Yes", "Yes", "No"], 
        //     // ["Yes", "No", "Yes", "No", "Yes"], 
        //     // ["Yes", "No", "Yes", "No", "No"], 
        //     // ["Yes", "No", "No", "Yes", "Yes"], 
        //     // ["Yes", "No", "No", "Yes", "No"], 
        //     // ["Yes", "No", "No", "No", "Yes"], 
        //     // ["Yes", "No", "No", "No", "No"], 
        //     // ["No", "Yes", "Yes", "Yes", "Yes"], 
        //     // ["No", "Yes", "Yes", "Yes", "No"], 
        //     // ["No", "Yes", "Yes", "No", "Yes"], 
        //     // ["No", "Yes", "Yes", "No", "No"], 
        //     // ["No", "Yes", "No", "Yes", "Yes"], 
        //     // ["No", "Yes", "No", "Yes", "No"], 
        //     // ["No", "Yes", "No", "No", "Yes"], 
        //     // ["No", "Yes", "No", "No", "No"], 
        //     // ["No", "No", "Yes", "Yes", "Yes"], 
        //     // ["No", "No", "Yes", "Yes", "No"], 
        //     // ["No", "No", "Yes", "No", "Yes"], 
        //     // ["No", "No", "Yes", "No", "No"], 
        //     // ["No", "No", "No", "Yes", "Yes"], 
        //     // ["No", "No", "No", "Yes", "No"], 
        //     // ["No", "No", "No", "No", "Yes"], 
        //     // ["No", "No", "No", "No", "No"]
        // ];
        
        // for($i = 0; $i < count($answer); $i++) {
        //     \App\Models\DoctorAnswer::factory()->create([
        //         'doctor_id' => $doctor->id,

        //         'topic_id' => $topic->id,
        //         'doctor_question_one_id'   => $question[0],
        //         'doctor_question_two_id'   => $question[1],
        //         'doctor_question_three_id' => $question[2],
        //         'doctor_question_four_id'  => $question[3],
        //         'doctor_question_five_id'  => $question[4],

        //         'doctor_answer_one'   => $answer[$i][0],
        //         'doctor_answer_two'   => $answer[$i][1],
        //         'doctor_answer_three' => $answer[$i][2],
        //         'doctor_answer_four'  => $answer[$i][3],
        //         'doctor_answer_five'  => $answer[$i][4],
        //         'answer' => fake()->sentence(6)
        //     ]);
        // }
    }
}
