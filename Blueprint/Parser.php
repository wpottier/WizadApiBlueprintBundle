<?php

namespace Wizad\ApiBlueprintBundle\Blueprint;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\Process\ProcessBuilder;

class Parser
{
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function parse($file)
    {
        $json = $this->getJson($file);
        // Remove extra line breaks before list item (Snowcrash bug : https://github.com/apiaryio/snowcrash/issues/214 )
        $json = str_replace(array('\n\n- ', '\n\n+ '), array('\n- ', '\n+ '), $json);


        $api = $this->serializer->deserialize($json, 'Wizad\ApiBlueprintBundle\Blueprint\Model\Api', 'json');

        return $api;
    }

    public function getJson($file)
    {
        $processBuilder = new ProcessBuilder(array('snowcrash', '-f', 'json', $file));
        $process = $processBuilder->getProcess();
        $process->run();

        if ($process->getExitCode() !== 0) {
            throw new \Exception($process->getErrorOutput(), $process->getExitCode());
        }

        return $process->getOutput();
    }
}