Getting Started With Locale Library
===================================

## Installation and usage

Installation and usage is a quick:

1. Download Locale using composer
2. Use the bundle


### Step 1: Download Locale library using composer

Add Locale library in your composer.json:

```json
{
    "require": {
        "fdevs/locale": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fdevs/locale
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Use the library

####Basic setup:

```php
<?php

require DIR . '/../vendor/autoload.php';

use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\Util\ChoiceText;

// The same text in different languages
$englishText = new LocaleText('I am a programmer', 'en');
$chineseText = new LocaleText('我是程序员', 'zh');
$russianText = new LocaleText('Я программист', 'ru');

$supportedTexts = [
    $englishText,
    $russianText,
    $chineseText,
];

$choice = new ChoiceText();
```

####Set default locale:
```php
$choice->setDefaultLocale('zh');
```

####Get text for current locale:
```php
// 1. Get text for current locale - ch (Chinese)
echo $choice->getText($supportedTexts);
// Output: "我是程序员"
```

####Get text for non default locale - ru:
```php
echo $choice->getText($supportedTexts, 'ru');
// Output: "Я программист"
```

####Get text for a locale for which we don't have translation:
```php
echo $choice->getText($supportedTexts, 'kk');
// Output: ""
```

####Get text using a set of prioritized locales:
Here you can treat this as locales fallback, first found locale from your list will be chosen.
```php
echo $choice->getTextByPriority($supportedTexts, ['en', 'zh', 'ru']);
// Output: "I am programmer"
```