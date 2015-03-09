<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class ResourceParameter 
{
    /**
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Type("string")
     */
    protected $description;

    /**
     * @Serializer\Type("string")
     */
    protected $type;

    /**
     * @Serializer\Type("boolean")
     */
    protected $required;

    /**
     * @Serializer\Type("string")
     */
    protected $default;

    /**
     * @Serializer\Type("string")
     */
    protected $example;

    /**
     * @Serializer\Type("array")
     */
    protected $values;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return mixed
     */
    public function getExample()
    {
        return $this->example;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }
}