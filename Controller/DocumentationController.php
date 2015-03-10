<?php

namespace Wizad\ApiBlueprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DocumentationController extends Controller
{
    public function indexAction(Request $request, $blueprint)
    {
        $api = $this->get('wizad_api_blueprint.blueprint.manager')->getBlueprint($blueprint);

        // Documentation description
        $markdownParser = new \Parsedown();
        $description = $markdownParser->text($api->getDescription());
        $regex = '#<h2>(.*?)</h2>(.*)#';
        preg_match_all($regex, $description, $descriptionHeading);
        $descriptionContent = preg_split($regex, $description, -1, PREG_SPLIT_NO_EMPTY);
        preg_match('#<p>(.*?)</p>#', array_shift($descriptionContent), $match);

        // Build the navigation
        $navigation = array();
        foreach ($descriptionHeading[1] as $heading) {
            $navigation[$heading] = $heading;
        }

        $navigationEndpoints = array('References' => array());
        foreach ($api->getResourceGroups() as $resourceGroup) {
            $key = 0;
            foreach ($resourceGroup->getResources() as $resource) {
                foreach ($resource->getActions() as $action) {
                    $navigationEndpoints['References'][$resourceGroup->getName()][$key]['method'] = $action->getMethod();
                    $navigationEndpoints['References'][$resourceGroup->getName()][$key]['name'] = $action->getName();

                    if (empty($navigationEndpoints['References'][$resourceGroup->getName()][$key]['name'])) {
                        $navigationEndpoints['References'][$resourceGroup->getName()][$key]['name'] = $resource->getName();
                    }

                    if (empty($navigationEndpoints['References'][$resourceGroup->getName()][$key]['name'])) {
                        $navigationEndpoints['References'][$resourceGroup->getName()][$key]['name'] = sprintf('%s %s', $action->getMethod(), $resource->getUriTemplate());
                    }

                    $key++;
                }
            }
        }

        return $this->render('WizadApiBlueprintBundle:Documentation:index.html.twig', array(
            'blueprintId' => $blueprint,
            'api' => $api,
            'intro' => isset($match[1]) ? $match[1] : null,
            'descriptionHeading' => $descriptionHeading[1],
            'descriptionContent' => $descriptionContent,
            'navigation' => $navigation,
            'navigationEndpoints' => $navigationEndpoints
        ));
    }
}