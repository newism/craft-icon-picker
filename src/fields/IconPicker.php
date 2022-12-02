<?php

namespace Newism\IconPicker\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\base\SortableFieldInterface;
use craft\helpers\Html;
use Newism\IconPicker\Plugin;
use Newism\IconPicker\web\assets\cp\CpAsset;
use yii\db\Schema;

class IconPicker extends Field implements SortableFieldInterface, PreviewableFieldInterface
{
    public string $iconFolderPath = '';
    public string $iconFolderUrl = '';

    public static function displayName(): string
    {
        return Craft::t('icon-picker', 'Icon Picker');
    }

    public function attributeHints(): array
    {
        return [
            'iconFolderPath' => 'Folder where icons are located',
            'iconFolderUrl' => 'Prepended to the icon file path',
        ];
    }

    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    public function getSettingsHtml(): ?string
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'icon-picker/_components/fieldtypes/IconPicker/settings',
            [
                'field' => $this,
                'settings' => $this->settings,
                'pluginSettings' => Plugin::$plugin->getSettings(),
            ]
        );
    }

    public function getInputHtml($value, ?ElementInterface $element = null): string
    {
        Craft::$app->getView()->registerAssetBundle(CpAsset::class);

        $id = Html::id($this->handle);
        $nameSpacedId = Craft::$app->getView()->namespaceInputId($id);
        [$options, $optgroups] = Plugin::$plugin->getCache()->getOptionsForField($this);

        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'icon-picker/_components/fieldtypes/IconPicker/input',
            [
                'id' => $id,
                'nameSpacedId' => $nameSpacedId,
                'field' => $this,
                'value' => $value,
                'settings' => $this->getSettings(),
                'pluginSettings' => Plugin::$plugin->getSettings(),
                'options' => $options,
                'optgroups' => $optgroups,
            ]
        );
    }

}
