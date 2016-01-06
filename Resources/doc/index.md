Getting Started With Locale Library
===================================

## Installation and usage

Installation and usage is a quick:

1. Download Locale using composer
2. Use the library
3. Use Mongodb with Symfony [Translation](https://github.com/symfony/Translation)


### Step 1: Download Locale library using composer

Download the bundle by running the command:

``` bash
$ php composer.phar require fdevs/locale
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Use the library

####Basic setup:

```php
<?php

require DIR . '/../vendor/autoload.php';

use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\Translator;

// The same text in different languages
$englishText = new LocaleText('I am a programmer', 'en');
$chineseText = new LocaleText('我是程序员', 'zh');
$russianText = new LocaleText('Я программист', 'ru');

$supportedTexts = [
    $englishText,
    $russianText,
    $chineseText,
];

$trans = new Translator();
```

####Set current locale:
```php
$trans->setLocale('zh');
```

####Get text for current locale:
```php
// 1. Get text for current locale - ch (Chinese)
$text = $trans->trans($supportedTexts);
echo $text?$text->getText():'';
// Output: "我是程序员"
```

####Get text for locale - ru:
```php
$text = $trans->trans($supportedTexts, 'ru');
echo $text?$text->getText():'';
// Output: "Я программист"
```

####Get text for a locale for which we don't have translation:
```php
$text = $trans->trans($supportedTexts, 'kk');
echo $text?$text->getText():'';
// Output: ""
```

####Get text using a set of prioritized locales:
Here you can treat this as locales fallback, first found locale from your list will be chosen.
```php
use FDevs\Locale\Model\PriorityLocale;
use FDevs\Locale\TranslatorPriority;

$priorityLocale = [
    new PriorityLocale('uk',['en','ru']),
    new PriorityLocale('en',['uk']),
    new PriorityLocale('fa',['zh','en']),
];

$trans = new TranslatorPriority('en',$priorityLocale);
$text = $trans->trans($supportedTexts, 'uk');
echo $text?$text->getText():'';
// Output: "I am programmer"
```

### Step 3: Use Mongodb with Symfony Translation


#### add resource

```php
use Symfony\Component\Translation\Translator;
use FDevs\Locale\Translation\Loader\MongodbLoader;

$translator = new Translator('fr_FR');
$translator->addLoader('mongodb', new MongodbLoader());

$mongoBD = new \MongoDB();
$collection = 'fdevs_translation';

$translator->addResource('mongodb', $mongoBD, 'ru', $collection);
$translator->addResource('mongodb', $mongoBD, 'en', $collection);

echo $translator->trans('welcome');
```

#### in mongodb

```json
/* 0 */
{
    "_id" : "symfony",
    "trans" : [ 
        {
            "text" : "Symfony is great",
            "locale" : "en"
        }, 
        {
            "text" : "Symfony это здорово",
            "locale" : "ru"
        }
    ]
}
```
