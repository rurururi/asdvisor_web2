<?php

namespace App\Livewire;

use Livewire\Component;

class CareDecision extends Component
{
    public $category = "";
    public $content = "";
    public $modal = false;

    public $questions = [
        "Does your child use any spoken words to communicate (even single words)?",
        'Does your child understand simple requests or instructions (e.g., "Come here", "Give me the toy")?',
        'Can your child use spoken language to express basic needs and wants (e.g., "Drink", "More", "Play")?',
        "Does your child's speech sound clear and easy to understand?",
        'Can your child use short phrases or sentences to communicate (e.g., "Want juice", "Go outside")?',
        "Does your child use language appropriately in social situations (e.g., greetings, turn-taking, requesting)?",
        "(Joint Attention): Does your child follow your gaze or point to share interest in objects or activities?",
        "(Gestures and Signs): Does your child use gestures or signs to communicate (e.g., pointing, waving, using picture symbols)?",
        "Does your child use nonverbal communication consistently and effectively to express needs and wants?",
        "Thank you"
    ];

    public $questionsTwo = [
        "Does your child seem overly sensitive to certain sights, sounds, smells, tastes, or textures? ",
        "Can you identify specific triggers for their sensitivity?",
        "When exposed to these triggers, does your child Withdraw or shut down or  Become irritable or frustrated or Engage in avoidance behaviors (covering ears, refusing textures)?",
        "Does this sensitivity seem to be constant across situations and moods, or does it vary?",
        "Does your child actively seek out intense sensory experiences (e.g., jumping on furniture, spinning objects, loud noises)?",
        "Are these behaviors disruptive or potentially dangerous?",
        "Does your child seem easily startled by sudden changes in sensory input? ",
        "Do your child's sensory sensitivities or seeking behaviors significantly impact their daily life (social interactions, play, sleep)?",
        "Thank you"
    ];

    public $questionsThree = [
        "Does your child consistently make good eye contact with others during conversations?",
        "Does your child consistently understand and respond appropriately to social cues (e.g., facial expressions, tone of voice)?",
        "Does your child typically initiate play with others and show interest in social interaction?",
        "Does your child consistently have difficulty taking turns during games or conversations?",
        "Does your child consistently understand and follow social rules (e.g., personal space, appropriate conversation topics)?",
        "Does your child rarely engage in repetitive or unusual movements, speech patterns, or behaviors in social settings?",
        "Does your child rarely have intense meltdowns or emotional outbursts triggered by social situations?",
        "Do these social interaction challenges significantly impact your child's daily life (school, friendships, activities)? ",
        "Thank you"
    ];

    public $currentQuestionIndex = 0;
    public $answers = [];
    public $setQuestion;
    
    public function setCategory($category) {
        $this->category = $category;

        if($category == "Speech Focused") {
            $this->setQuestion = $this->questions[0];
        } else if($category == "Sensory Focused") {
            $this->setQuestion = $this->questionsTwo[0];
        } else if($category == "Social Interaction") {
            $this->setQuestion = $this->questionsThree[0];
        }
    }

    public function close() {
        $this->answers = [];
        $this->modal = false;
        $this->content = "";
        $this->category = "";
        $this->currentQuestionIndex = 0;
        $this->setQuestion = "";
    }

    public function nextQuestion($answer) {
        if($this->category == "Speech Focused") {
            if ($this->currentQuestionIndex == 0 && $answer == "Yes") {
            $this->answers[] = [$this->currentQuestionIndex, $answer];
            $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
            $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
            // Jumps to question 9
            else if ($this->currentQuestionIndex == 0 && $answer == "No") {
            $this->answers[] = [$this->currentQuestionIndex, $answer];
            $this->currentQuestionIndex = $this->currentQuestionIndex + 8;
            $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
            //question 2
            else if ($this->currentQuestionIndex == 1 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 1 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 3
            else if ($this->currentQuestionIndex == 2 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 2 && $answer == "No") {

                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 4
            else if ($this->currentQuestionIndex == 3 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 3 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 5
            else if ($this->currentQuestionIndex == 4 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 4 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 6
            else if ($this->currentQuestionIndex == 5 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 5 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 7
            else if ($this->currentQuestionIndex == 6 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 6 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 8
            //either answer ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 7 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 7 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 9;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //question 9
            //either answers ends the questions and gives recommendations
            else if ($this->currentQuestionIndex == 8 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            } else if ($this->currentQuestionIndex == 8 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
            }
        
            //resets everything
            if ($this->currentQuestionIndex == 9) {
                $this->currentQuestionIndex = 0;
                $this->setQuestion = $this->questions[$this->currentQuestionIndex];
                $this->CareResults($this->answers);
            }
        } else if($this->category == "Sensory Focused") {
            if ($this->currentQuestionIndex == 0 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
              // ends the tree
              else if ($this->currentQuestionIndex == 0 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
              //question 2
              else if ($this->currentQuestionIndex == 1 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 1 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //question 3
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 2 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //proceeds to next question
              else if ($this->currentQuestionIndex == 2 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //question 4
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 3 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //next question
              else if ($this->currentQuestionIndex == 3 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //question 5
              else if ($this->currentQuestionIndex == 4 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 4 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //question 6
              //ends the questions and gives recommendation
              else if ($this->currentQuestionIndex == 5 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //next question
              else if ($this->currentQuestionIndex == 5 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //question 7
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 6 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //next question
              else if ($this->currentQuestionIndex == 6 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //question 8
              //either answer ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 7 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 7 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
              }
          
              //resets everything
              if ($this->currentQuestionIndex == 8) {
                $this->currentQuestionIndex = 0;
                $this->setQuestion = $this->questionsTwo[$this->currentQuestionIndex];
                $this->CareResults($this->answers);
            }
        } else if($this->category == "Social Interaction") {
            if ($this->currentQuestionIndex == 0 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
              // ends the tree
              else if ($this->currentQuestionIndex == 0 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
              //question 2
              else if ($this->currentQuestionIndex == 1 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 1 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //question 3
              //proceeds to next question
              else if ($this->currentQuestionIndex == 2 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 2 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //question 4
              //next question
              else if ($this->currentQuestionIndex == 3 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 3 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //question 5
              else if ($this->currentQuestionIndex == 4 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 4 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //question 6
              //ends the questions and gives recommendation
              else if ($this->currentQuestionIndex == 5 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //next question
              else if ($this->currentQuestionIndex == 5 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //question 7
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 6 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //next question
              else if ($this->currentQuestionIndex == 6 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = $this->currentQuestionIndex + 1;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //question 8
              //either answer ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 7 && $answer == "Yes") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //ends the questions and gives recommendations
              else if ($this->currentQuestionIndex == 7 && $answer == "No") {
                $this->answers[] = [$this->currentQuestionIndex, $answer];
                $this->currentQuestionIndex = 8;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
              }
          
              //resets everything
              if ($this->currentQuestionIndex == 8) {
                $this->currentQuestionIndex = 0;
                $this->setQuestion = $this->questionsThree[$this->currentQuestionIndex];
                $this->CareResults($this->answers);
              }
        }
    }

    public function CareResults($answer) {
        if($this->category == "Speech Focused") {
            if ($answer[1][0] == 8 && $answer[1][1] == "No") {
                $content = 'Consider consulting an occupational therapist or SLP to explore strategies for improving nonverbal communication';
            } elseif ($answer[1][0] == 8 && $answer[1][1] == "Yes") {
                $content = 'This suggests effective use of nonverbal communication. While focusing on spoken language development, acknowledge and respond to nonverbal cues.';
            } elseif ($answer[1][0] == 1 && $answer[1][1] == "No") {
                $content = 'Consider consulting a healthcare professional or developmental specialist for further evaluation of receptive language skills.';
            } elseif ($answer[2][0] == 2 && $answer[2][1] == "No") {
                $content = 'Seek an evaluation from a speech-language pathologist (SLP) for therapy approaches to develop expressive language skills.';
            } elseif ($answer[3][0] == 3 && $answer[3][1] == "No") {
                $content = 'Seek an evaluation from a speech-language pathologist to address articulation or oral motor concerns.';
            } elseif ($answer[4][0] == 4 && $answer[4][1] == "No") {
                $content = 'Seek an evaluation from a speech-language pathologist to develop strategies for building sentence structure and grammar skills.';
            } elseif ($answer[5][0] == 5 && $answer[5][1] == "No") {
                $content = 'Consider consulting a healthcare professional or SLP for strategies to improve social communication skills.';
            } elseif ($answer[6][0] == 6 && $answer[6][1] == "No") {
                $content = 'Consider consulting a healthcare professional or developmental specialist for strategies to develop joint attention.';
            } elseif ($answer[7][0] == 7 && $answer[7][1] == "No") {
                $content = 'While focusing on developing spoken language skills, acknowledge attempts at communication through any means.';
            } elseif ($answer[7][0] == 7 && $answer[7][1] == "Yes") {
                $content = 'This suggests using alternative communication methods. Consider an evaluation for Augmentative and Alternative Communication (AAC) options.';
            }
        } else if($this->category == "Sensory Focused") {
            if (
                $answer[0][0] == 0 &&
                $answer[0][1] == "No"
              ) {
                $content = 'Continue monitoring your child\'s sensory preferences. If you notice any significant changes in their sensitivity or it starts to impact their daily life, consider seeking professional guidance from a healthcare professional or therapist.';
              } else if (
                $answer[1][0] == 1 &&
                $answer[1][1] == "No"
              ) {
                $content = 'Consider seeking professional evaluation for broader sensory processing issues. A therapist can help explore potential underlying reasons for the sensitivities and develop strategies for managing them.';
              } else if (
                $answer[2][0] == 2 &&
                $answer[2][1] == "Yes"
              ) {
                $content = 'This suggests your child might be experiencing significant sensory reactions. Consider seeking professional guidance from a therapist or occupational therapist. A therapist or occupational therapist can provide a comprehensive evaluation, personalized strategies (including sensory integration techniques), and support for both yourself and your child.';
              } else if (
                $answer[3][0] == 3 &&
                $answer[3][1] == "Yes"
              ) {
                $content = 'Consider seeking professional guidance for consistent sensitivity. Constant sensitivity might require specific strategies.';
              } else if (
                $answer[4][0] == 4 &&
                $answer[4][1] == "No"
              ) {
                $content = 'Recommendation: This suggests typical sensory processing. However, you can still support your child\'s sensory needs by providing them with opportunities for safe and controlled sensory exploration throughout the day.';
              } else if (
                $answer[5][0] == 5 &&
                $answer[5][1] == "Yes"
              ) {
                $content = 'Consider consulting a therapist to develop strategies for managing seeking behaviors in a safe and appropriate way. A therapist can help identify alternative sensory activities that meet your child\'s needs without causing disruption or posing a safety risk. Consider creating a "sensory diet" that incorporates safe and controlled sensory input throughout the day.';
              } else if (
                $answer[6][0] == 6 &&
                $answer[6][1] == "Yes"
              ) {
                $content = 'Consider consulting a professional to explore this further, it could indicate a different sensory processing issue, such as sensory defensiveness. A therapist can help develop strategies for managing these reactions.';
              } else if (
                $answer[7][0] == 7 &&
                $answer[7][1] == "Yes"
              ) {
                $content = 'consider seeking professional guidance from a therapist or occupational therapist. Sensory processing difficulties can impact a child\'s ability to function in everyday situations. A therapist can:\n• Conduct a comprehensive evaluation to identify the specific sensory systems affected and the severity of the challenges.\n• Develop individualized strategies to help your child manage their sensitivities or seeking behaviors. This may include sensory integration techniques, environmental modifications, and social skills training.\n• Provide support and guidance for you and your child as you navigate these challenges.\n• Recommend helpful resources and tools.';
              } else if (
                $answer[7][0] == 7 &&
                $answer[7][1] == "No"
              ) {
                $content = 'This suggests that your child\'s sensory processing is likely within the typical range. However, it\'s still important to continue monitoring their sensory preferences. If you notice any significant changes or have any concerns, don\'t hesitate to seek professional guidance.';
              }
        } else if($this->category == "Social Interaction") {
            if (
                $answer[0][0] == 0 &&
                $answer[0][1] == "No"
              ) {
                $content = 'Difficulty with eye contact can be a sign of social interaction
                challenges. Consider seeking professional guidance from a therapist or
                developmental specialist. Early intervention can be beneficial for
                addressing these difficulties. A professional can assess your child\'s
                specific needs and develop a personalized plan to improve their eye
                contact and overall social interaction skills.';
              } else if (
                $answer[1][0] == 1 &&
                $answer[1][1] == "No"
              ) {
                $content = 'Difficulty interpreting social cues can hinder social interactions.
                Consider seeking professional guidance from a therapist or
                speech-language pathologist (SLP). A therapist can help your child
                develop strategies for interpreting facial expressions, body language,
                and tone of voice. SLPs can also work on improving communication skills
                that can support social interaction.';
              } else if (
                $answer[2][0] == 2 &&
                $answer[2][1] == "No"
              ) {
                $content = 'If your child shows a preference for solitary play and little interest
                in engaging with others, consider seeking professional guidance. A
                therapist or social worker can help your child develop the skills needed
                to initiate play, take turns, and cooperate with others. Social skills
                groups can also be a beneficial environment for practicing social
                interaction.';
              } else if (
                $answer[3][0] == 3 &&
                $answer[3][1] == "No"
              ) {
                $content = 'Difficulty with turn-taking can disrupt social interactions. Consider
                seeking professional guidance from a therapist or social worker. A
                therapist can help your child develop strategies for turn-taking and
                sharing. Social skills groups can also provide opportunities to practice
                these skills in a safe environment.';
              } else if (
                $answer[4][0] == 4 &&
                $answer[4][1] == "No"
              ) {
                $content = 'Difficulty understanding and following social rules can cause challenges
                in social situations. Consider seeking professional guidance from a
                therapist or social worker. A therapist can help your child develop
                social scripts for different situations and practice appropriate
                greetings, conversation starters, and body language.';
              } else if (
                $answer[5][0] == 5 &&
                $answer[5][1] == "No"
              ) {
                $content = 'While repetitive behaviors are sometimes associated with ASD, they can
                also occur in typical development. However, if you notice these
                behaviors significantly interfere with social interactions, consider
                seeking professional guidance for evaluation';
              } else if (
                $answer[6][0] == 6 &&
                $answer[6][1] == "Yes"
              ) {
                $content = 'While occasional meltdowns or emotional outbursts can happen, frequent
                occurrences triggered by social situations might warrant professional
                guidance. A therapist can help your child develop coping mechanisms for
                managing anxiety and frustration in social situations. Social skills
                groups can also provide a safe space to practice emotional regulation
                skills.';
              } else if (
                $answer[7][0] == 7 &&
                $answer[7][1] == "Yes"
              ) {
                $content = 'Because these challenges significantly impact your child\'s daily life,
                seeking professional guidance is crucial. Schedule an evaluation with a
                qualified professional like your child\'s pediatrician or a mental health
                specialist specializing in child development. They can assess your
                child\'s needs and recommend appropriate interventions, such as therapy,
                social skills training, or speech-language pathology services. Early
                intervention is key for overcoming social interaction challenges and
                improving your child\'s overall well-being.';
              } else if (
                $answer[7][0] == 7 &&
                $answer[7][1] == "No"
              ) {
                $content = 'It\'s encouraging that social interactions don\'t significantly impact
                your child\'s daily life. Remember, social development is ongoing. Keep
                supporting your child by providing opportunities to interact with peers
                (playdates, activities), modeling social skills (greetings,
                turn-taking), and practicing social scenarios at home. Celebrate their
                social successes! If any concerns arise, seek professional guidance.';
              }
        }

        $this->content = $content;
        $this->modal = true;
    }
    public function render()
    {
        return view('livewire.care-decision');
    }
}
