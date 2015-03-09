<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class Api
{
    // region Properties

    /**
     * @Serializer\SerializedName("_version")
     * @Serializer\Type("string")
     */
    protected $version;

    /**
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ApiMetadata>")
     */
    protected $metadata;

    /**
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Type("string")
     */
    protected $description;

    /**
     * @Serializer\SerializedName("resourceGroups")
     * @Serializer\Type("array<Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceGroup>")
     */
    protected $resourceGroups;

    // endregion

    // region Getters

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ApiMetadata[]
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceGroup[]
     */
    public function getResourceGroups()
    {
        return $this->resourceGroups;
    }

    // endregion
}