<?php
namespace Application\Security\QuestionsAndAnswers;

use Application\Configuration\Configuration;
use Application\HttpRequest\HttpRequest;

class QuestionsAndAnswers
{
    use Configuration;

    /**
    * Field name
    * 
    * @var string
    */
    private $field_name;

    /**
    * Construct
    * 
    * @param string $field_name
    * @return void
    */
    public function __construct($field_name)
    {
        $this->field_name = $field_name;
    }

    /**
    * Validate
    * 
    * @return bool
    */
    public function validate()
    {
        
    }
}