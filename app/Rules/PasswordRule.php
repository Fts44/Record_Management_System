<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PasswordRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->uppercasePasses = (Str::lower($value) !== $value);
        $this->lowercasePasses = (Str::upper($value) !== $value);
        $this->numericPasses = ((bool) preg_match('/[0-9]/', $value));
        $this->specialCharacterPasses = ((bool) preg_match('/[^A-Za-z0-9]/', $value));

        return ($this->lengthPasses && $this->uppercasePasses && $this->numericPasses && $this->specialCharacterPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $error_msg = "Your password must contain";

        if($this->lengthPasses){
            $error_msg.="<span class='text-success'><br> &#x2714; 8 characters </span>";
        }
        else{
            $error_msg.="<span class='text-danger'><br> &#x2716; 8 characters </span>";
        }

        if($this->uppercasePasses){
            $error_msg.="<span class='text-success'><br> &#x2714; 1 upper case </span>";
        }
        else{
            $error_msg.="<span class='text-danger'><br> &#x2716; 1 upper case </span>";
        }

        if($this->lowercasePasses){
            $error_msg.="<span class='text-success'><br> &#x2714; 1 lower case </span>";
        }
        else{
            $error_msg.="<span class='text-danger'><br> &#x2716; 1 lower case </span>";
        }

        if($this->numericPasses){
            $error_msg.="<span class='text-success'><br> &#x2714; 1 number </span>";
        }
        else{
            $error_msg.="<span class='text-danger'><br> &#x2716; 1 number </span>";
        }

        if($this->specialCharacterPasses){
            $error_msg.="<span class='text-success'><br> &#x2714; 1 symbol </span>";
        }
        else{
            $error_msg.="<span class='text-danger'><br> &#x2716; 1 symbol </span>";
        }

        return $error_msg;
    }
}
