<?php

namespace Wizad\ApiBlueprintBundle\Twig;

use Cocur\Slugify\Slugify;
use Symfony\Component\Translation\TranslatorInterface;
use Wizad\ApiBlueprintBundle\Blueprint\BlueprintManager;

class WizadApiBlueprintExtension extends \Twig_Extension
{
    static $units = array(
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var BlueprintManager
     */
    protected $blueprintsManager;

    /**
     * @var \Parsedown
     */
    protected $markdownParser;

    public function __construct($blueprintsManager, TranslatorInterface $translator = null)
    {
        $this->blueprintsManager = $blueprintsManager;
        $this->markdownParser = new \Parsedown();
        $this->translator = $translator;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'wizad_api_blueprint';
    }

    public function getGlobals()
    {
        return array(
            'blueprints' => $this->blueprintsManager->getValidIds()
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('markdown', array($this, 'filterMarkdown'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('slugify', array($this, 'filterSlugify')),
            new \Twig_SimpleFilter('time_diff', array($this, 'filterDiff'), array('needs_environment' => true)),
        );
    }

    public function filterMarkdown($value, $line = false)
    {
        if (!$line) {
            $result = $this->markdownParser->text($value);
        }
        else {
            $result = $this->markdownParser->line($value);
        }

        return $result;
    }

    public function filterSlugify($string, $prefix = null, $suffix = null) {
        $slugify = new Slugify();
        return $slugify->slugify($prefix.$string.$suffix);
    }

    /**
     * Filter for converting dates to a time ago string like Facebook and Twitter has.
     *
     * @param \Twig_Environment $env  A Twig_Environment instance.
     * @param string|\DateTime  $date A string or DateTime object to convert.
     * @param string|\DateTime  $now  A string or DateTime object to compare with. If none given, the current time will be used.
     *
     * @return string The converted time.
     */
    public function filterDiff(\Twig_Environment $env, $date, $now = null)
    {
        // Convert both dates to DateTime instances.
        $date = twig_date_converter($env, $date);
        $now = twig_date_converter($env, $now);
        // Get the difference between the two DateTime objects.
        $diff = $date->diff($now);
        // Check for each interval if it appears in the $diff object.
        foreach (self::$units as $attribute => $unit) {
            $count = $diff->$attribute;
            if (0 !== $count) {
                return $this->getPluralizedInterval($count, $diff->invert, $unit);
            }
        }
        return '';
    }

    protected function getPluralizedInterval($count, $invert, $unit)
    {
        if ($this->translator) {
            $id = sprintf('diff.%s.%s', $invert ? 'in' : 'ago', $unit);
            return $this->translator->transChoice($id, $count, array('%count%' => $count), 'date');
        }
        if ($count > 1) {
            $unit .= 's';
        }
        return $invert ? "in $count $unit" : "$count $unit ago";
    }
}