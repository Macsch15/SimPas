<?php
namespace Application\Security\QuestionsAndAnswers;

use Application\Configuration\Configuration;
use Application\HttpRequest\HttpRequest;
use Application\Exception\ExceptionRuntime;

class QuestionsAndAnswers
{
    use Configuration;

    /**
    * Validate
    *
    * @param string $field_client_question
    * @param string $field_client_answer
    * @return bool
    */
    public function validate($field_client_question, $field_client_answer)
    {
        if(count($this->config('QuestionsAndAnswers', true)) <= 0) {
            throw new ExceptionRuntime('You must define some question and answer in configuration file.');
        }

        $valid = false;

        if(is_array($this->config('QuestionsAndAnswers', true)[$field_client_question]) === true) {
            foreach($this->config('QuestionsAndAnswers', true)[$field_client_question] as $answer) {
                if(trim(strtolower($field_client_answer)) == trim(strtolower($answer))) {
                    $valid = true;
                }
            }
        } else {
            if(trim(strtolower($field_client_answer)) == 
                trim(strtolower($this->config('QuestionsAndAnswers', true)[$field_client_question]))
            ) {
                $valid = true;
            }
        }

        return $valid;
    }

    /**
    * Fetch random question
    * 
    * @return string
    */
    public function question()
    {
        if(count($this->config('QuestionsAndAnswers', true)) <= 0) {
            throw new ExceptionRuntime('You must define some question and answer in configuration file.');
        }

        $questions_container = [];
        foreach($this->config('QuestionsAndAnswers', true) as $question => $answer) {
            $questions_container[] = $question;
        }

        return $questions_container[array_rand($questions_container)];
    }
}
