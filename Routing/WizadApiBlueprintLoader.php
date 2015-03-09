<?php

namespace Wizad\ApiBlueprintBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Wizad\ApiBlueprintBundle\Blueprint\BlueprintManager;

class WizadApiBlueprintLoader extends Loader
{
    protected $blueprintManager;

    public function __construct(BlueprintManager $blueprintManager)
    {
        $this->blueprintManager = $blueprintManager;
    }

    /**
     * Loads a resource.
     *
     * @param mixed $resource The resource
     * @param string|null $type The resource type or null if unknown
     *
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();

        $ids = $this->blueprintManager->getValidIds();
        $i = 1;

        foreach ($ids as $blueprintId) {
            $blueprint = $this->blueprintManager->getBlueprint($blueprintId);

            foreach ($blueprint->getResourceGroups() as $resourceGroup) {

                foreach($resourceGroup->getResources() as $resource) {

                    foreach ($resource->getActions() as $action) {
                        // Remove optional get parameters (query string)
                        $uriTemplateParts = explode('{?', $resource->getUriTemplate());
                        $uriTemplate = $uriTemplateParts[0];

                        $route = new Route('mock/' . $blueprintId .$uriTemplate);
                        $route
                            ->setRequirement('_method', $action->getMethod())
                            ->setDefault('_controller', 'WizadApiBlueprintBundle:Mock:handle')
                            ->setDefault('blueprint', $blueprintId)
                            ->setDefault('path', $resource->getUriTemplate())
                        ;

                        $routes->add('_wizad_api_blueprint_mockup_'.$i++, $route);
                    }
                }
            }
        }

        return $routes;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'wizad_api_blueprint' == $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {

    }


}