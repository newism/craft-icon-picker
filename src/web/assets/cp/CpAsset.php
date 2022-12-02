<?php

namespace Newism\IconPicker\web\assets\cp;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset as CraftCpAsset;
use craft\web\assets\prismjs\PrismJsAsset;
use craft\web\assets\selectize\SelectizeAsset;

class CpAsset extends AssetBundle
{
    public $depends = [
        CraftCpAsset::class,
        SelectizeAsset::class
    ];

    public $sourcePath = __DIR__ . '/dist';

    public $css = [
        'IconPicker.css'
    ];

    public $js = [
        'IconPicker.js'
    ];
}
