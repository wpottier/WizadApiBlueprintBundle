<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class ResourceActionExampleResponse
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
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\Header>")
     */
    protected $headers;

    /**
     * @Serializer\Type("string")
     */
    protected $body;

    /**
     * @Serializer\Type("string")
     */
    protected $schema;

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
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\Header[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }
}