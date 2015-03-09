<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class ResourceActionExample
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
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExampleRequest>")
     */
    protected $requests;

    /**
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExampleResponse>")
     */
    protected $responses;

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
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExampleRequest[]
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExampleResponse[]
     */
    public function getResponses()
    {
        return $this->responses;
    }
}