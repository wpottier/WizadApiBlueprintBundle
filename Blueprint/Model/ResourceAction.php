<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class ResourceAction 
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
    protected $method;

    /**
     * @Serializer\Type("array")
     */
    protected $parameters;

    /**
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExample>")
     */
    protected $examples;

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
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExample[]
     */
    public function getExamples()
    {
        return $this->examples;
    }
}