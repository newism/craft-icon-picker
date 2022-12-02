<?php

namespace Newism\IconPicker;

use Craft;
use craft\events\RegisterCacheOptionsEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use craft\utilities\ClearCaches;
use Newism\IconPicker\fields\IconPicker;
use Newism\IconPicker\models\SettingsModel;
use Newism\IconPicker\services\Cache;
use yii\base\Event;

/**
 * @method SettingsModel getSettings()
 */
class Plugin extends \craft\base\Plugin
{
    public static Plugin $plugin;
    public bool $hasCpSettings = false;

    public $id = 'icon-picker';

    public function init()
    {
        self::$plugin = $this;

        $this->setComponents([
            'cache' => Cache::class,
        ]);

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = IconPicker::class;
            }
        );

        Event::on(ClearCaches::class, ClearCaches::EVENT_REGISTER_CACHE_OPTIONS, function(RegisterCacheOptionsEvent $event) {
            $event->options[] = [
                'key' => 'icon-picker',
                'label' => Craft::t('icon-picker', 'Icon Picker cache'),
                'action' => [$this->getCache(), 'clear'],
            ];
        });

        parent::init();
    }

    public function getCache(): Cache
    {
        return $this->get('cache');
    }

    /**
     * Create a settings model
     */
    protected function createSettingsModel(): SettingsModel
    {
        return new SettingsModel();
    }

    /**
     * Render the settings html
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->getView()->renderTemplate(
            'icon-picker/settings',
            ['settings' => $this->getSettings()]
        );
    }
}
