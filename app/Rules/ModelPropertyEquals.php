<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ModelPropertyEquals implements Rule
{
    private $model;
    private $property;
    private $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $property, $value)
    {
        $this->model = $model;
        $this->property = $property;
        $this->value = $value;
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
        $modelClass = $this->model;
        $model = $modelClass::find($value);
        if($model === null)
            return false;

        return $model->{$this->property} === $this->value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
