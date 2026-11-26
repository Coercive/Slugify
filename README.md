# Coercive Slugify Utility

Slugify allows you to clean the characters in a string for treatment of URL rewriting for example. Other options can detect proper names, clean spaces, move text into utf8 etc ...

## Get

```
composer require coercive/slugify
```

## Usage

**URL**
```php
use Coercive\Utility\Slugify;

$sTitleArticle = 'My title is not made to work with a URL rewriting directly, it must be processed before.';
$sSlug = (new Slugify)->clean($sTitleArticle);
# my-title-is-not-made-to-work-with-a-url-rewriting-directly-it-must-be-processed-before
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

**BALANCE INLINE TAGS**

Repairs badly closed inline formatting tags (`b`, `i`, `u`, `s`, `strong`, `em`, `small`, `mark`, `sup`, `sub`) that would turn the rest of the page bold / italic: truncated excerpts, old imports, orphan or overlapping tags. Other tags and the text are never modified, and a balanced string is returned unchanged.
```php
use Coercive\Utility\Slugify\Slugify;

(new Slugify)->balanceInlineTags('<strong><em>Truncated excerpt…');
# <strong><em>Truncated excerpt…</em></strong>

(new Slugify)->balanceInlineTags('The urban sprawl (<I>suburbs<I>) and the city');
# The urban sprawl (<I>suburbs</I>) and the city

(new Slugify)->balanceInlineTags('<strong><em>a</strong>b</em>');
# <strong><em>a</em></strong><em>b</em>

(new Slugify)->balanceInlineTags('<em><em>ethos</em></em>');
# <em><em>ethos</em></em> (legit nesting is kept)

# Custom tags list
(new Slugify)->balanceInlineTags('<span>a<i>b', ['span']);
# <span>a<i>b</span>
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