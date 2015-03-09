<?php

namespace Wizad\ApiBlueprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InspectorController extends Controller
{
    public function indexAction($blueprint)
    {
        return $this->render('WizadApiBlueprintBundle:Inspector:index.html.twig', array('blueprintId' => $blueprint));
    }

    public function mockupAction($blueprint)
    {
        $mockUrl = $this->generateUrl('wizad_api_blueprint_mock_root', array('blueprint' => $blueprint), UrlGeneratorInterface::ABSOLUTE_URL);

        $profiles = $this->get('profiler')->find('', $mockUrl, 100, '', '', '');

        $profiles = array_map(function($profile) use ($mockUrl) {

            $profile['time'] = date_create_from_format('U', $profile['time']);
            $profile['url'] = str_replace($mockUrl, '', $profile['url']);

            return $profile;
        }, $profiles);

        return $this->render('WizadApiBlueprintBundle:Inspector:mockup.html.twig', array(
            'blueprintId' => $blueprint,
            'mockUrl' => $mockUrl,
            'profiles' => $profiles
        ));
    }
}