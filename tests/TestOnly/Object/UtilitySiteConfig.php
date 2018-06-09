<?php

namespace Dynamic\TemplateConfig\Tests\TestOnly;

use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\Dev\TestOnly;
use Dynamic\TemplateConfig\ORM\UtilityDataExtension;

/**
 * Class UtilitySiteConfig.
 */
class UtilitySiteConfig extends TemplateConfigSetting implements TestOnly
{
    private static $extensions = [UtilityDataExtension::class];

    /**
     * @var string
     */
    private static $table_name = 'UtilitySiteConfig_Test';
}
