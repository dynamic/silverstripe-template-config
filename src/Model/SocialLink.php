<?php

namespace Dynamic\TemplateConfig\Model;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

/**
 * Class SocialLink
 * @package Dynamic\TemplateConfig\Model
 *
 * @property string $Title
 * @property string $Link
 * @property int $SortOrder
 * @property string $Site
 *
 * @property int $GlobalConfigID
 * @method TemplateConfigSetting GlobalConfig()
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
     * @var bool
     */
    private static $show_google = false;

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => 'Title',
        'Site' => 'Site',
    ];

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder DESC';

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(150)',
        'Link' => 'Varchar(255)',
        'SortOrder' => 'Int',
        'Site' => 'Enum("facebook, youtube, twitter, linkedin, google, pinterest, instagram")',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'GlobalConfig' => TemplateConfigSetting::class,
    ];

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName([
                'GlobalConfigID',
                'SortOrder',
            ]);

            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create(
                    'Site',
                    'Site',
                    $this->getNetworks()
                )->setEmptyString('')
            );
        });
        return parent::getCMSFields();
    }

    /**
     * @return array
     */
    protected function getNetworks()
    {
        $networks = $this->dbObject('Site')->enumValues();

        if (!$this->config()->get('show_google')) {
            unset($networks['google']);
        }

        return $networks;
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
        return [
            'Social_CRUD' => 'Create, Update and Delete a Social Link',
        ];
    }
}
