<?php

namespace Newism\IconPicker\services;

use Craft;
use Newism\IconPicker\fields\IconPicker;
use Symfony\Component\Finder\Finder;
use yii\base\Exception;
use yii\caching\TagDependency;

class Cache
{
    private const OPTIONS_FIELD_KEY_PREFIX = 'newism-icon-picker-options-';
    private const OPTIONS_TAG = 'newism-icon-picker-options';

    public function clear(): void
    {
        TagDependency::invalidate(Craft::$app->getCache(), self::OPTIONS_TAG);
    }

    public function clearOptionsForField(IconPicker $field): void
    {
        Craft::$app->cache->delete(self::OPTIONS_FIELD_KEY_PREFIX . $field->handle);
    }

    public function getOptionsForField(IconPicker $field): array
    {
        return Craft::$app->getCache()->getOrSet(
            self::OPTIONS_FIELD_KEY_PREFIX . $field->handle,
            function () use ($field) {
                $iconFolderPath = Craft::getAlias($field->iconFolderPath);
                $iconFolderUrl = Craft::getAlias($field->iconFolderUrl);
                if (!$iconFolderPath) {
                    throw new Exception('Newism Icon Picker requires an iconPath config setting');
                }

                $finder = new Finder();
                $files = $finder->files()->in($iconFolderPath)->name('*.svg')->sortByName();

                $options = [];
                $optGroups = [];
                foreach ($files as $file) {
                    $optGroups[$file->getRelativePath()] = [
                        'folder' => $file->getRelativePath(),
                    ];
                    $options[] = [
                        'folder' => $file->getRelativePath(),
                        'filename' => str_replace(rtrim($iconFolderPath, '/') . '/', '', $file->getPathname()),
                        'src' => Craft::getAlias(rtrim($iconFolderUrl, '/') . '/' .$file->getRelativePathname()),
//                        'svg' => $file->getContents()
                    ];
                }
                return [$options, array_values($optGroups)];
            }, null, new TagDependency([
                'tags' => self::OPTIONS_TAG,
            ])
        );
    }
}
