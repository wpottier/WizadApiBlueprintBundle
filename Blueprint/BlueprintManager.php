<?php

namespace Wizad\ApiBlueprintBundle\Blueprint;

use Symfony\Component\Filesystem\Filesystem;
use Wizad\ApiBlueprintBundle\Blueprint\Model\Api;

class BlueprintManager
{
    /**
     * @var Parser
     */
    protected $parser;

    protected $blueprints;

    protected $kernelRootdir;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(Parser $parser, $blueprints, $kernelRootdir)
    {
        $this->parser = $parser;
        $this->blueprints = $blueprints;
        $this->kernelRootdir = $kernelRootdir;
        $this->filesystem = new Filesystem();
    }

    public function getIds()
    {
        return array_keys($this->blueprints);
    }

    public function getValidIds()
    {
        $blueprints = array();

        foreach ($this->blueprints as $blueprintId => $blueprint) {
            if (!$this->filesystem->exists($blueprint['file'])) {
                continue;
            }

            $blueprints[] = $blueprintId;
        }

        return $blueprints;
    }

    public function getBlueprintMetadata($id)
    {
        if (!array_key_exists($id, $this->blueprints)) {
            throw new \InvalidArgumentException();
        }

        $fileExist = $this->filesystem->exists($this->blueprints[$id]['file']);

        if ($fileExist) {

            $realFilePath = realpath($this->blueprints[$id]['file']);
            $dirname = dirname($realFilePath);
            $basename = basename($realFilePath);

            $relativePath = $this->filesystem->makePathRelative($dirname, realpath($this->kernelRootdir . '/../')) . $basename;

            $file = strlen($realFilePath) > strlen($relativePath) ? $relativePath : $realFilePath;
        }
        else {
            $file = $this->blueprints[$id]['file'];
        }


        return [
            'file' => $file,
            'fileExist' => $fileExist,
            'updatedAt' => $fileExist ? \DateTime::createFromFormat('U', filemtime($this->blueprints[$id]['file'])) : null,
        ];
    }

    /**
     * @param $id
     * @return Api
     */
    public function getBlueprint($id)
    {
        if (!array_key_exists($id, $this->blueprints)) {
            throw new \InvalidArgumentException();
        }

        if (!array_key_exists('model', $this->blueprints[$id])) {
            $this->blueprints[$id]['model'] = $this->parser->parse($this->blueprints[$id]['file']);
        }

        return $this->blueprints[$id]['model'];
    }
}