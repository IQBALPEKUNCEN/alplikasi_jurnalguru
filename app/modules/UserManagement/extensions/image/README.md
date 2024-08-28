# Kohana Image for Yii 2

Image manipulations (resize, crop, watermark, etc)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist webvimark/image "*"
```

or add

```
"webvimark/image": "*"
```

to the require section of your `composer.json` file.

## Configuration

In your config/web.php

```php
	'modules'=>[
		...

		'migrations'=>[
			'class'=>'app\modules\UserManagement\extensions\modules\migrations\MigrationModule'
		],

		...
	],
```

In you config/console.php

```php
	...

	'controllerMap'=>[
		'migrate'=>[
			'class'=>'app\modules\UserManagement\extensions\modules\migrations\components\MigrateController',
		],
	],

	...
```

Include your desired modules in config/console.php

## Usage

```php
\app\modules\UserManagement\extensions\image\Image::factory($pathFromFile)->resize(500, 300)->save($pathToFile);
```
