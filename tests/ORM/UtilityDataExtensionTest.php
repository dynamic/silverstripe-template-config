<?php

namespace Dynamic\TemplateConfig\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\TemplateConfig\Tests\TestOnly\UtilitySiteConfig;
use SilverStripe\Forms\FieldList;

/**
 * Class UtilityNavigationManagerTest.
 */
class UtilityDataExtensionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var array
     */
    public static $extra_data_objects = [
        UtilitySiteConfig::class,
    ];

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()
            ->create(UtilitySiteConfig::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('UtilityLinks'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('UtilityLinks'));
    }
}
