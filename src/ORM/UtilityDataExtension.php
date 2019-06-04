<?php

namespace Dynamic\TemplateConfig\ORM;

use Sheadawson\Linkable\Models\Link;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class UtilityDataExtension
 * @package Dynamic\TemplateConfig\ORM
 *
 * @method ManyManyList UtilityLinks()
 * @method ManyManyList UtilityMenu()
 */
class UtilityDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = [
        'UtilityLinks' => SiteTree::class,
        'UtilityMenu' => Link::class,
    ];

    /**
     * @var array
     */
    private static $many_many_extraFields = [
        'UtilityLinks' => [
            'SortOrder' => 'Int',
        ],
        'UtilityMenu' => [
            'SortOrder' => 'Int',
        ],
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->exists()) {
            $config = GridFieldConfig_RelationEditor::create()
                ->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldArchiveAction::class,
                    GridFieldDeleteAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldDeleteAction(false)
                );
            $links = $this->owner->UtilityMenu()->sort('SortOrder');

            $linksField = GridField::create(
                'UtilityMenu',
                'Links',
                $links,
                $config
            );

            $fields->addFieldsToTab('Root.UtilityMenu', [
                HeaderField::create('UtilityHD', 'Utility Navigation', 3),
                LiteralField::create(
                    'UtilityDescrip',
                    '<p>Add links to the utility navigation area of your template.</p>'
                ),
                $linksField
                    ->setDescription('Add links to the utility navigation area'),
            ]);
        }
    }

    /**
     * @param ManyManyList $results
     */
    public function updateManyManyComponents($results)
    {
        if ($results->getJoinTable() == $this->owner->config()->get('table_name') . '_UtilityMenu') {
            $results->sort('SortOrder');
        }
    }
}
