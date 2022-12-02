# Icon Picker Field for Craft CMS

A simple icon picker for CraftCMS.

![Closed dropdown](resources/field-preview.png)
![Open dropdown](resources/field-preview-open.png)

## Installation

```shell
composer require newism/craft-icon-picker -w && php craft plugin/install icon-picker
```

## Configuration

Each field has independent configuration.

* `Icon Folder Path`: Path to the icon folder. eg: `@root/public/icons`
* `Icon Folder Url`: Public URL for icons. eg: `@web/icons`

Note: Icons must be accessible from a public URL

![Field Settings](resources/field-settings.png)

## TODO

* Write docs
* Release it
