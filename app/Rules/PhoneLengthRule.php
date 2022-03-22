<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneLengthRule implements Rule
{
    public $country;
    public $length = 0;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($country)
    {
        $this->country = $country;
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
        if ($this->country == 77 && strlen($value) > 9) {
            $this->length = 9;
            return false;
        }

        if ($this->country == 50 && strlen($value) > 10) {
            $this->length = 10;
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La longeur du numéro ne doit pas dépasser ' . $this->length . ' caractères';
    }
}
