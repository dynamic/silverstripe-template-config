<?php

namespace Dynamic\TemplateConfig\Tests\ORM;

use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

/**
 * Class SocialConfigTest.
 */
class SocialConfigTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(TemplateConfigSetting::class, 'settings');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
