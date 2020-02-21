<?php

namespace Application\Security\QuestionsAndAnswers;

use Application\Configuration\Configuration;
use Application\Exception\ExceptionRuntime;

class QuestionsAndAnswers
{
    use Configuration;

    /**
     * Validate.
     *
     * @param string $field_client_question
     * @param string $field_client_answer
     *
     * @throws ExceptionRuntime
     *
     * @return bool
     */
    public function validate($field_client_question, $field_client_answer)
    {
        if (count($this->config('qa')) <= 0) {
            throw new ExceptionRuntime('You must define some question and answer in configuration file.');
        }

        $valid = false;

        if ($field_client_question == null || $field_client_answer == null) {
            return $valid;
        }

        $strcmp = function ($left, $right) {
            if ($this->config()['antispam_case_sensitive'] === true) {
                return strcmp($left, $right);
            }

            return strcasecmp($left, $right);
        };

        if (is_array($this->config('qa')[$field_client_question]) === true) {
            foreach ($this->config('qa')[$field_client_question] as $answer) {
                if ($strcmp($field_client_answer, $answer) === 0) {
                    $valid = true;
                }
            }
        } else {
            if ($strcmp($field_client_answer, $this->config('qa')[$field_client_question]) === 0) {
                $valid = true;
            }
        }

        return $valid;
    }

    /**
     * Fetch random question.
     *
     * @throws ExceptionRuntime
     *
     * @return string
     */
    public function question()
    {
        if (count($this->config('qa')) <= 0) {
            throw new ExceptionRuntime('You must define some question and answer in configuration file.');
        }

        $questions_container = [];

        foreach ($this->config('qa') as $question => $answer) {
            $questions_container[] = $question;
        }

        return $questions_container[array_rand($questions_container)];
    }
}
