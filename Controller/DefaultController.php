<?php

namespace Wizad\ApiBlueprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $blueprintManager = $this->get('wizad_api_blueprint.blueprint.manager');

        $blueprintsMetadata = array();
        foreach($blueprintManager->getIds() as $blueprintId) {
            $blueprintsMetadata[$blueprintId] = $this->get('wizad_api_blueprint.blueprint.manager')->getBlueprintMetadata($blueprintId);
        }

        return $this->render('WizadApiBlueprintBundle:Default:index.html.twig', array(
            'blueprintsMetadata' => $blueprintsMetadata
        ));
    }
}
