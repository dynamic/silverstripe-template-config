<?php

namespace Dynamic\TemplateConfig\Tests\ORM;

use SilverStripe\Assets\Image;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\TemplateConfig\ORM\TemplateConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class TemplateConfigTest.
 */
class BrandingDataExtensionTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        SiteConfig::add_extension(TemplateConfig::class);
    }

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create(SiteConfig::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('TitleLogo'));
    }

    /**
     *
     */
    public function testGetSiteLogo()
    {
        $object = Injector::inst()->create(SiteConfig::class);
        $logo = $this->objFromFixture(Image::class, 'logo');
        $object->LogoID = $logo->ID;
        $this->assertInstanceOf(Image::class, $object->getSiteLogo());
    }
}
