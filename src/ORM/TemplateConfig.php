<?php

namespace Dynamic\TemplateConfig\ORM;

use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Assets\Image;

/**
 * Class TemplateConfig.
 *
 * @property string $TitleLogo
 * @property int $LogoID
 */
class TemplateConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'TitleLogo' => "Enum(array('Logo', 'Title'))",
        "Title" => "Varchar(255)",
        "Tagline" => "Varchar(255)",
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Logo' => Image::class,
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'TitleLogo' => 'Title',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $ImageField = UploadField::create('Logo');
        $ImageField->getValidator()->allowedExtensions = array(
            'jpg',
            'gif',
            'png',
        );
        $ImageField->setFolderName('Uploads/Logo');
        $ImageField->setIsMultiUpload(false);

        // options for logo or title display
        $logoOptions = array(
            'Logo' => 'Display Logo',
            'Title' => 'Display Site Title and Slogan',
        );

        $fields->removeByName([
            'TitleLogo',
            'Title',
            'Tagline',
        ]);

        $fields->addFieldsToTab('Root.Main', array(
            HeaderField::create('BrandingHD', 'Branding', 2),
            LiteralField::create('HeaderDescrip', '<p>Adjust the settings of your template header.</p>'),
            $titlelogo = OptionsetField::create('TitleLogo', 'Branding', $logoOptions),
            $title = TextField::create("Title", _t(SiteConfig::class . '.SITETITLE', "Site title")),
            $tagline = TextField::create("Tagline", _t(SiteConfig::class . '.SITETAGLINE', "Site Tagline/Slogan")),
            $ImageField,
        ));

        $title->hideUnless($titlelogo->getName())->isEqualTo('Title');
        $tagline->hideUnless($titlelogo->getName())->isEqualTo('Title');
        
        $ImageField->hideUnless($titlelogo->getName())->isEqualTo('Logo');
    }

    /**
     * @return mixed
     */
    public function getSiteLogo()
    {
        return ($this->owner->Logo()) ? $this->owner->Logo() : false;
    }

    /**
     * @return mixed
     */
    public function getFooterLinkList()
    {
        return ($this->owner->FooterLinks()
            ->exists()) ? $this->owner->FooterLinks()
            ->sort('SortOrder') : false;
    }
}
