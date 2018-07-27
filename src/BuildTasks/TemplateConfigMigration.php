<?php

namespace Dynamic\TemplateConfig\BuildTasks;

use Dynamic\CoreTools\Model\GlobalSiteSetting;
use Dynamic\TemplateConfig\Model\NavigationColumn;
use Dynamic\TemplateConfig\Model\NavigationGroup;
use Dynamic\TemplateConfig\Model\SocialLink;
use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class TemplateConfigMigration
 * @package Dynamic\TemplateConfig\BuildTasks
 */
class TemplateConfigMigration extends BuildTask
{

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     */
    public function run($request)
    {
        /** @var TemplateConfigSetting|\Dynamic\TemplateConfig\ORM\BrandingDataExtension $templateConfig */
        $templateConfig = TemplateConfigSetting::current_template_config();
        $siteConfig = SiteConfig::current_site_config();

        $configUpdate = function ($object) {
            $object->GlobalConfigID = $templateConfig->ID;
        };

        $groupCount = $this->updateObject(NavigationGroup::class);
        echo "Updated {$groupCount} navigation groups.<br />";


        $columnCount = $this->updateObject(NavigationColumn::class, $configUpdate);
        echo "Updated {$columnCount} navigation columns.<br />";

        $socialCount = $this->updateObject(SocialLink::class, $configUpdate);
        echo "Updated {$socialCount} social links.<br />";


        $templateConfig->Title = $siteConfig->Title;
        $templateConfig->TagLine = $siteConfig->Tagline;
        echo "Updated the branding.<br />";
    }

    /**
     * @param \SilverStripe\ORM\DataObject|string $class
     * @param callable|array|null $extra
     *
     * @return int
     */
    public function updateObject($class, $extra = null)
    {
        $count = 0;
        /** @var \SilverStripe\ORM\DataObject $object */
        foreach ($this->iterate($class) as $object) {
            $object->ClassName = $class;
            if (is_array($extra)) {
                foreach ($extra as $func) {
                    if (is_callable($func)) {
                        $func($object);
                    }
                }
            } else {
                if (is_callable($extra)) {
                    $extra($object);
                }
            }
            $object->write();
            $count++;
        }
        return $count;
    }

    /**
     * Only gets objects with outdated class names
     *
     * @param \SilverStripe\ORM\DataObject|string $class
     * @return \Generator<$class>
     */
    public function iterate($class)
    {
        foreach ($class::get()->exclude('ClassName', $class) as $object) {
            yield $object;
        }
    }
}
