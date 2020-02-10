<?php

namespace App\Support\Validation;

abstract class Validator
{
    /**
     * @var array
     */
    private $data;

    /**
     * Get validation rules.
     *
     * @return array
     */
    abstract public function rules() : array;

    /**
     * Get validation messages.
     *
     * @return array
     */
    abstract public function messages() : array;

    /**
     * Validator constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validation handler.
     *
     * @return bool
     * @throws ValidationException
     *
     */
    public function validate()
    {
        $validation = \Validator::make($this->data, $this->rules(), $this->messages());

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return true;
    }

    /**
     * Get a data key magically.
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }
}
