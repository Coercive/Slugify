Coercive Slugify Utility
========================

Slugify allows you to clean the characters in a string for treatment of URL rewriting for example. Other options can detect proper names, clean spaces, move text into utf8 etc ...

Get
---
```
composer require coercive/slugify
```

Usage
-----

**URL**
```php
use Coercive\Utility\Slugify;

$sTitleArticle = 'My title is not made to work with a URL rewriting directly, it must be processed before.';
$sSlug = (new Slugify)->clean($sTitleArticle);

# GIVE : my-title-is-not-made-to-work-with-a-url-rewriting-directly-it-must-be-processed-before

```

**SUMMARY**
```php
use Coercive\Utility\Slugify;

$sText = 'Long text ... Very Long Text ...';
$sSummary = (new Slugify)->substrText($sText);

# GIVE : 300chars text

$sSummary = (new Slugify)->substrText($sText, 500);

# GIVE : 500chars text
```

**NAME**
```php
use Coercive\Utility\Slugify;

$sName = 'Mary Antoinette';
$bIsName = (new Slugify)->pregName($sName);

# True

$sName = '@Not A valid name !';
$bIsName = (new Slugify)->pregName($sName);

# False
```

**TO UTF8**
```php
use Coercive\Utility\Slugify;

$sString = '&#33;&#87;&#126;&quot;&middot;&oslash;&Upsilon;&psi;';
$sUtf8String = (new Slugify)->toUTF8($sString);
```