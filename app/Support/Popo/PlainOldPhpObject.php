<?php

namespace App\Support\Popo;

use Illuminate\Database\Eloquent\Model;

class PlainOldPhpObject
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * Retrieve all model attributes and remove all
     * sensitive attributes from the list.
     *
     * @param Model $model
     * @return array
     */
    private function filterAllowedAttributes(Model $model)
    {
        $hiddenAttributes = $model->getHidden();
        $attributes = collect($model->getAttributes());

        foreach ($hiddenAttributes as $key => $value) {
            if ($attributes->has($value)) {
                $attributes->forget($value);
            }
        }

        return $attributes->all();
    }

    /**
     * The Eloquent Model parser.
     *
     * @param Model $model
     * @return PlainOldPhpObject
     */
    public static function parse(Model $model)
    {
        $_this = new static();
        $_this->attributes = $_this->filterAllowedAttributes($model);

        return $_this;
    }

    /**
     * Retrieve all parsed attributes.
     *
     * @return array
     */
    public function all()
    {
        return $this->attributes;
    }

    /**
     * Get a property by name.
     *
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->{$name};
    }

    /**
     * Check if a property exists.
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Get a Popo property magically.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->has($name)
            ? $this->attributes[$name]
            : null;
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        throw new \Exception(
            "Set value to a property in a POPO class is not allowed."
        );
    }
}
