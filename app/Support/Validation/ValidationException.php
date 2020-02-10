<?php

namespace App\Support\Validation;

use Illuminate\Support\MessageBag;

class ValidationException extends \Exception
{
    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * ValidationException constructor.
     *
     * @param MessageBag $errors
     */
    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
        parent::__construct("ValidationException", 0, null);
    }

    /**
     * @param string $key
     * @return array
     */
    public function get(string $key)
    {
        return $this->errors->get($key);
    }

    /**
     * Get all errors.
     *
     * @return array
     */
    public function all()
    {
        return $this->errors->all();
    }

    /**
     * Get first error.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->errors->first();
    }

    /**
     * Get last error.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->all());
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->errors->count();
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return $this->errors->toJson();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
