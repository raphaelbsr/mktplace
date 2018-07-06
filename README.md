mktplace
========
mktplace

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist raphaelbsr/yii2-i9swmktplace "*"
```

or add

```
"raphaelbsr/yii2-i9swmktplace": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \raphaelbsr\mktplace\AutoloadExample::widget(); ?>```

```
yii migrate/up --migrationPath=@vendor/raphaelbsr/yii2-mktplace/migrations
```