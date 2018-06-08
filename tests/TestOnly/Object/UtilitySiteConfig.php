<?php

namespace Dynamic\TemplateConfig\Tests\TestOnly;

use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Dev\TestOnly;
use Dynamic\TemplateConfig\ORM\UtilityNavigationManager;

/**
 * Class UtilitySiteConfig.
 */
class UtilitySiteConfig extends TemplateConfigSetting implements TestOnly
{
    private static $extensions = [UtilityNavigationManager::class];

    /**
     * @var string
     */
    private static $table_name = 'UtilitySiteConfig_Test';
}
