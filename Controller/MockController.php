<?php

namespace Wizad\ApiBlueprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wizad\ApiBlueprintBundle\Blueprint\Model\ResourceActionExampleResponse;

class MockController extends Controller
{
    public function handleAction(Request $request, $blueprint, $path)
    {
        $api = $this->get('wizad_api_blueprint.blueprint.manager')->getBlueprint($blueprint);



        foreach ($api->getResourceGroups() as $resourceGroup) {

            foreach ($resourceGroup->getResources() as $resource) {
                if ($resource->getUriTemplate() != $path) {
                    continue;
                }

                foreach ($resource->getActions() as $action) {
                    if ($action->getMethod() != $request->getMethod()) {
                        continue;
                    }

                    // Select example
                    $selectedExample = null;
                    foreach($action->getExamples() as $example) {
                        if (!$selectedExample) {
                            $selectedExample = $example;
                        }
                    }

                    if (!$selectedExample) {
                        throw $this->createNotFoundException();
                    }

                    // Select response to send
                    $selectedResponse = null;
                    foreach($selectedExample->getResponses() as $response) {
                        if (!$selectedResponse) {
                            $selectedResponse = $response;
                        }

                        if (intval($response->getName()) < intval($selectedResponse->getName())) {
                            $selectedResponse = $response;
                        }
                    }

                    if (!$selectedResponse) {
                        throw $this->createNotFoundException();
                    }

                    // Send response
                    return $this->prepareHttpResponse($selectedResponse);
                }

                break 2;
            }
        }

        throw $this->createNotFoundException();
    }

    /**
     * @param ResourceActionExampleResponse $blueprintResponse
     */
    protected function prepareHttpResponse(ResourceActionExampleResponse $blueprintResponse)
    {
        $httpResponse = new Response(null, $blueprintResponse->getName());

        foreach ($blueprintResponse->getHeaders() as $header) {
            $httpResponse->headers->set($header->getName(), $header->getValue(), true);
        }

        $httpResponse->setContent($blueprintResponse->getBody());

        return $httpResponse;
    }
}