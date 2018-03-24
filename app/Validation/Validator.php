<?php


namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;
    
    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            
            try {
                $rule->setName(ucwords(str_replace("_", " ", $field)))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        
        //TAKE THE ERRORS AND THEN SAVE IT IN A SESSION WHERE WE CAN GET
        // IT IN THE MIDDLEWARE VALIDATION ERRORS MIDDLEWARE
        $_SESSION['formErrors'] = $this->errors;
        
        return $this;
    }
    
    public function failed()
    {
        return !empty($this->errors);
    }
    
}