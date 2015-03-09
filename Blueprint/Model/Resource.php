<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class Resource 
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
     * @Serializer\SerializedName("uriTemplate")
     */
    protected $uriTemplate;

    /**
     * @Serializer\Type("Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceModel")
     */
    protected $model;

    /**
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceParameter>")
     */
    protected $parameters;

    /**
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceAction>")
     */
    protected $actions;

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
    public function getUriTemplate()
    {
        return $this->uriTemplate;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceParameter[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceAction[]
     */
    public function getActions()
    {
        return $this->actions;
    }
}