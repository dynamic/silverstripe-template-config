<?php

namespace Dynamic\TemplateConfig\Model;

use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

/**
 * Class SocialLink.
 */
class SocialLink extends DataObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $singular_name = 'Social Link';

    /**
     * @var string
     */
    private static $plural_name = 'Social Links';

    /**
     * @var string
     */
    private static $table_name = 'SocialLink';

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Title' => 'Title',
        'Site' => 'Site',
    );

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder DESC';

    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(150)',
        'Link' => 'Varchar(255)',
        'SortOrder' => 'Int',
        'Site' => 'Enum("facebook, youtube, twitter, linkedin, google, pinterest, instagram")',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'GlobalConfig' => TemplateConfigSetting::class,
    );

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'GlobalConfigID',
            'SortOrder',
        ));

        $fields->addFieldToTab(
            'Root.Main',
            DropdownField::create(
                'Site',
                'Site',
                $this->dbObject('Site')->enumValues()
            )->setEmptyString('')
        );

        return $fields;
    }

    /**
     * @param null|Member $member
     *
     * @return bool
     */
    public function canView($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null|Member $member
     *
     * @return bool|int
     */
    public function canEdit($member = null, $context = [])
    {
        return Permission::check('Social_CRUD', 'any', $member);
    }

    /**
     * @param null|Member $member
     *
     * @return bool|int
     */
    public function canDelete($member = null, $context = [])
    {
        return Permission::check('Social_CRUD', 'any', $member);
    }

    /**
     * @param null|Member $member
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('Social_CRUD', 'any', $member);
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
            'Social_CRUD' => 'Create, Update and Delete a Social Link',
        );
    }
}
