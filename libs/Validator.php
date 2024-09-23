<?php
namespace App;
class Validator
{
    public $errors = [];

    public function validateEmail($email) {
        if (empty($email)) {
            $this->errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Valid email is required';
        }
    }

    public function confirmPassword($password,$confirmPassword){
        if($password !== $confirmPassword ){
            $this->errors[] = 'Password must be equal to Confirm Password';
        }
    }

    public function validateNoOfCharacters($string,$noOfCharacters = 6){
        if(strlen($string) < $noOfCharacters){
            $this->errors[] = "The number of characters must be at least $noOfCharacters characters" ;
        }
    }
    public function validateNotEmpty($value, $fieldName) {
        if (empty($value)) {
            $this->errors[] = "$fieldName must be provided";
        }
    }

    public  function validateNumber($value, $fieldName) {
        if(empty($value)) {
            $this->errors[] = "$fieldName must be provided";
        }
        elseif (!is_numeric($value)) {
           $this->errors[] = "$fieldName must be a number";
        }
    }
    public function validateMobile($mobile) {
        if (empty($mobile)) {
            $this->errors[] = 'Mobile no must be provided';
        } elseif (strlen($mobile) != 11) {
            $this->errors[] = 'Mobile must be 11 digits';
        } elseif (!ctype_digit($mobile)) {
            $this->errors[] = 'Mobile must be a valid number';
        }
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}
?>