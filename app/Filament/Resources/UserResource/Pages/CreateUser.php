<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = UserResource::class;

    protected function beforeCreate(): void
    {
        if($this->data['account_level'] == "Doctor") {
            $question = [];
            
            $user = User::create($this->data);

            for($i = 0; $i < 5; $i++) {
                $question[] = \App\Models\DoctorQuestion::factory()->create([
                    'doctor_id' => $user->id,
                    'question' => 'Example Question #'.($i+1),
                    'sort' => $i + 1
                ]);
            }
            
            $answer = [
                ["Yes", "Yes", "Yes", "Yes", "Yes"], 
                ["Yes", "Yes", "Yes", "Yes", "No"], 
                ["Yes", "Yes", "Yes", "No", "Yes"], 
                ["Yes", "Yes", "Yes", "No", "No"], 
                ["Yes", "Yes", "No", "Yes", "Yes"], 
                ["Yes", "Yes", "No", "Yes", "No"], 
                ["Yes", "Yes", "No", "No", "Yes"], 
                ["Yes", "Yes", "No", "No", "No"], 
                ["Yes", "No", "Yes", "Yes", "Yes"], 
                ["Yes", "No", "Yes", "Yes", "No"], 
                ["Yes", "No", "Yes", "No", "Yes"], 
                ["Yes", "No", "Yes", "No", "No"], 
                ["Yes", "No", "No", "Yes", "Yes"], 
                ["Yes", "No", "No", "Yes", "No"], 
                ["Yes", "No", "No", "No", "Yes"], 
                ["Yes", "No", "No", "No", "No"], 
                ["No", "Yes", "Yes", "Yes", "Yes"], 
                ["No", "Yes", "Yes", "Yes", "No"], 
                ["No", "Yes", "Yes", "No", "Yes"], 
                ["No", "Yes", "Yes", "No", "No"], 
                ["No", "Yes", "No", "Yes", "Yes"], 
                ["No", "Yes", "No", "Yes", "No"], 
                ["No", "Yes", "No", "No", "Yes"], 
                ["No", "Yes", "No", "No", "No"], 
                ["No", "No", "Yes", "Yes", "Yes"], 
                ["No", "No", "Yes", "Yes", "No"], 
                ["No", "No", "Yes", "No", "Yes"], 
                ["No", "No", "Yes", "No", "No"], 
                ["No", "No", "No", "Yes", "Yes"], 
                ["No", "No", "No", "Yes", "No"], 
                ["No", "No", "No", "No", "Yes"], 
                ["No", "No", "No", "No", "No"]
            ];
            
            for($i = 0; $i < 32; $i++) {
                \App\Models\DoctorAnswer::factory()->create([
                    'doctor_id' => $user->id,
                    'doctor_question_one_id'   => $question[0],
                    'doctor_question_two_id'   => $question[1],
                    'doctor_question_three_id' => $question[2],
                    'doctor_question_four_id'  => $question[3],
                    'doctor_question_five_id'  => $question[4],

                    'doctor_answer_one'   => $answer[$i][0],
                    'doctor_answer_two'   => $answer[$i][1],
                    'doctor_answer_three' => $answer[$i][2],
                    'doctor_answer_four'  => $answer[$i][3],
                    'doctor_answer_five'  => $answer[$i][4],
                    'answer' => fake()->sentence(6)
                ]);
            }
            Notification::make()
                ->success()
                ->title('Saved')
                ->body('Successfully created.')
                ->send();
            redirect($this->getResource()::getUrl('index'));
            $this->halt();
        }
    }
}
