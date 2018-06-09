<?php

namespace Dynamic\TemplateConfig\Tests\TestOnly\Object;

use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\Dev\TestOnly;
use Dynamic\TemplateConfig\ORM\FooterDataExtension;

/**
 * Class FooterSiteConfig.
 */
class FooterSiteConfig extends TemplateConfigSetting implements TestOnly
{
    /**
     * @var array
     */
    private static $extensions = [FooterDataExtension::class];

    /**
     * @var string
     */
    private static $table_name = 'FooterSiteConfig_Test';
}
