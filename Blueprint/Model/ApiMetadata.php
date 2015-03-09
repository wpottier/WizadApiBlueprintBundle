<?php

namespace Wizad\ApiBlueprintBundle\Blueprint\Model;

use JMS\Serializer\Annotation as Serializer;

class ApiMetadata 
{
    /**
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @Serializer\Type("string")
     */
    protected $value;

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
    public function getValue()
    {
        return $this->value;
    }


}