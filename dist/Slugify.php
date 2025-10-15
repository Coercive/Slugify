<?php
namespace Coercive\Utility\Slugify;

use DOMDocument;
use DOMElement;
use DOMException;
use DOMXPath;

/**
 * Slugify
 *
 * @package Coercive\Utility\Slugify
 * @link https://github.com/Coercive/Slugify
 *
 * @author Anthony Moral <contact@coercive.fr>
 * @copyright © 2025 Anthony Moral
 * @license MIT
 */
class Slugify
{
	const ALPHABET_MAP = [
		'À' => 'A',
		'Á' => 'A',
		'Â' => 'A',
		'Ã' => 'A',
		'Ä' => 'A',
		'Å' => 'A',
		'Æ' => 'AE',
		'Ç' => 'C',
		'È' => 'E',
		'É' => 'E',
		'Ê' => 'E',
		'Ë' => 'E',
		'Ì' => 'I',
		'Í' => 'I',
		'Î' => 'I',
		'Ï' => 'I',
		'Ð' => 'D',
		'Ñ' => 'N',
		'Ò' => 'O',
		'Ó' => 'O',
		'Ô' => 'O',
		'Õ' => 'O',
		'Ö' => 'O',
		'Ø' => 'O',
		'Ù' => 'U',
		'Ú' => 'U',
		'Û' => 'U',
		'Ü' => 'U',
		'Ý' => 'Y',
		'ẞ' => 'SS',
		'ß' => 'ss',
		'à' => 'a',
		'á' => 'a',
		'â' => 'a',
		'ã' => 'a',
		'ä' => 'a',
		'å' => 'a',
		'æ' => 'ae',
		'ç' => 'c',
		'è' => 'e',
		'é' => 'e',
		'ê' => 'e',
		'ë' => 'e',
		'ì' => 'i',
		'í' => 'i',
		'î' => 'i',
		'ï' => 'i',
		'ñ' => 'n',
		'ò' => 'o',
		'ó' => 'o',
		'ô' => 'o',
		'õ' => 'o',
		'ö' => 'o',
		'ø' => 'o',
		'ù' => 'u',
		'ú' => 'u',
		'û' => 'u',
		'ü' => 'u',
		'ý' => 'y',
		'ÿ' => 'y',
		'Ā' => 'A',
		'ā' => 'a',
		'Ă' => 'A',
		'ă' => 'a',
		'Ą' => 'A',
		'ą' => 'a',
		'Ć' => 'C',
		'ć' => 'c',
		'Ĉ' => 'C',
		'ĉ' => 'c',
		'Ċ' => 'C',
		'ċ' => 'c',
		'Č' => 'C',
		'č' => 'c',
		'Ď' => 'D',
		'ď' => 'd',
		'Đ' => 'D',
		'đ' => 'd',
		'Ē' => 'E',
		'ē' => 'e',
		'Ĕ' => 'E',
		'ĕ' => 'e',
		'Ė' => 'E',
		'ė' => 'e',
		'Ę' => 'E',
		'ę' => 'e',
		'Ě' => 'E',
		'ě' => 'e',
		'Ĝ' => 'G',
		'ĝ' => 'g',
		'Ğ' => 'G',
		'ğ' => 'g',
		'Ġ' => 'G',
		'ġ' => 'g',
		'Ģ' => 'G',
		'ģ' => 'g',
		'Ĥ' => 'H',
		'ĥ' => 'h',
		'Ħ' => 'H',
		'ħ' => 'h',
		'Ĩ' => 'I',
		'ĩ' => 'i',
		'Ī' => 'I',
		'ī' => 'i',
		'Ĭ' => 'I',
		'ĭ' => 'i',
		'Į' => 'I',
		'į' => 'i',
		'İ' => 'I',
		'ı' => 'i',
		'Ĳ' => 'IJ',
		'ĳ' => 'ij',
		'Ĵ' => 'J',
		'ĵ' => 'j',
		'Ķ' => 'K',
		'ķ' => 'k',
		'Ĺ' => 'L',
		'ĺ' => 'l',
		'Ļ' => 'L',
		'ļ' => 'l',
		'Ľ' => 'L',
		'ľ' => 'l',
		'Ŀ' => 'L',
		'ŀ' => 'l',
		'Ł' => 'L',
		'ł' => 'l',
		'Ń' => 'N',
		'ń' => 'n',
		'Ņ' => 'N',
		'ņ' => 'n',
		'Ň' => 'N',
		'ň' => 'n',
		'ŉ' => 'n',
		'Ō' => 'O',
		'ō' => 'o',
		'Ŏ' => 'O',
		'ŏ' => 'o',
		'Ő' => 'O',
		'ő' => 'o',
		'Œ' => 'OE',
		'œ' => 'oe',
		'Ŕ' => 'R',
		'ŕ' => 'r',
		'Ŗ' => 'R',
		'ŗ' => 'r',
		'Ř' => 'R',
		'ř' => 'r',
		'Ś' => 'S',
		'ś' => 's',
		'Ŝ' => 'S',
		'ŝ' => 's',
		'Ş' => 'S',
		'ş' => 's',
		'Ș' => 'S',
		'ș' => 's',
		'Š' => 'S',
		'š' => 's',
		'Ţ' => 'T',
		'ţ' => 't',
		'Ť' => 'T',
		'ť' => 't',
		'Ŧ' => 'T',
		'ŧ' => 't',
		'Ũ' => 'U',
		'ũ' => 'u',
		'Ū' => 'U',
		'ū' => 'u',
		'Ŭ' => 'U',
		'ŭ' => 'u',
		'Ů' => 'U',
		'ů' => 'u',
		'Ű' => 'U',
		'ű' => 'u',
		'Ų' => 'U',
		'ų' => 'u',
		'Ŵ' => 'W',
		'ŵ' => 'w',
		'Ŷ' => 'Y',
		'ŷ' => 'y',
		'Ÿ' => 'Y',
		'Ź' => 'Z',
		'ź' => 'z',
		'Ż' => 'Z',
		'ż' => 'z',
		'Ž' => 'Z',
		'ž' => 'z',
		'ſ' => 's',
		'ƒ' => 'f',
		'Ơ' => 'O',
		'ơ' => 'o',
		'Ư' => 'U',
		'ư' => 'u',
		'Ǎ' => 'A',
		'ǎ' => 'a',
		'Ǐ' => 'I',
		'ǐ' => 'i',
		'Ǒ' => 'O',
		'ǒ' => 'o',
		'Ǔ' => 'U',
		'ǔ' => 'u',
		'Ǖ' => 'U',
		'ǖ' => 'u',
		'Ǘ' => 'U',
		'ǘ' => 'u',
		'Ǚ' => 'U',
		'ǚ' => 'u',
		'Ǜ' => 'U',
		'ǜ' => 'u',
		'Ǻ' => 'A',
		'ǻ' => 'a',
		'Ǽ' => 'AE',
		'ǽ' => 'ae',
		'Ǿ' => 'O',
		'ǿ' => 'o',

		# Cyrillic alphabet
		'А' => 'A',
		'Ӓ' => 'A',
		'А́' => 'A',
		'А̀' => 'A',
		'Ӑ' => 'A',
		'А̄' => 'A',
		'А̊' => 'A',
		'Ӓ̄' => 'A',
		'а' => 'a',
		'ӓ' => 'a',
		'а́' => 'a',
		'а̀' => 'a',
		'ӑ' => 'a',
		'а̄' => 'a',
		'а̊' => 'a',
		'ӓ̄' => 'a',
		'Б' => 'B',
		'б' => 'b',
		'В' => 'V',
		'в' => 'v',
		'Г' => 'G',
		'г' => 'g',
		'Д' => 'D',
		'д' => 'd',
		'Е' => 'IE',
		'Ӗ' => 'IE',
		'е' => 'ie',
		'ӗ' => 'ie',
		'Ё' => 'IO',
		'ё' => 'io',
		'Ж' => 'J',
		'Ӂ' => 'J',
		'Җ' => 'J',
		'Ӝ' => 'J',
		'ж' => 'j',
		'ӂ' => 'j',
		'җ' => 'j',
		'ӝ' => 'j',
		'З' => 'Z',
		'з' => 'z',
		'И' => 'I',
		'Ҋ' => 'I',
		'Ӥ' => 'I',
		'Ӣ' => 'I',
		'и' => 'i',
		'ҋ' => 'i',
		'ӥ' => 'i',
		'Й' => 'I',
		'й' => 'i',
		'ӣ' => 'i',
		'І' => 'I',
		'і' => 'i',
		'К' => 'K',
		'к' => 'k',
		'Л' => 'L',
		'л' => 'l',
		'М' => 'M',
		'м' => 'm',
		'Н' => 'N',
		'н' => 'n',
		'О' => 'O',
		'о' => 'o',
		'П' => 'P',
		'п' => 'p',
		'Р' => 'P',
		'р' => 'p',
		'С' => 'S',
		'с' => 's',
		'Т' => 'T',
		'т' => 't',
		'У' => 'OU',
		'у' => 'ou',
		'Ф' => 'F',
		'ф' => 'f',
		'Х' => 'KH',
		'х' => 'kh',
		'Ц' => 'TS',
		'ц' => 'ts',
		'Ч' => 'TCH',
		'ч' => 'tch',
		'Ш' => 'CH',
		'ш' => 'ch',
		'Щ' => 'CHTCH',
		'щ' => 'chtch',
		'Ъ' => '',
		'ъ' => '',
		'Ы' => 'Y',
		'ы' => 'y',
		'Ь' => '',
		'ь' => '',
		'Ѣ' => 'E',
		'ѣ' => 'e',
		'Э' => 'E',
		'э' => 'e',
		'Ю' => 'YOU',
		'ю' => 'you',
		'Я' => 'IA',
		'я' => 'ia',
		'Ѳ' => 'F',
		'ѳ' => 'f',
		'Ѵ' => 'Y',
		'ѵ' => 'y',

		# Greek alphabet

		# Common Greek Combinations
		'γγ' => 'ng', 'Γγ' => 'Ng', 'ΓΓ' => 'NG',
		'γκ' => 'gk', 'Γκ' => 'Gk', 'ΓΚ' => 'GK',
		'γχ' => 'nch', 'Γχ' => 'Nch', 'ΓΧ' => 'NCH',

		'α' => 'a',
		'ά' => 'a',
		'ὰ' => 'a',
		'ἀ' => 'a',
		'ἄ' => 'a',
		'ἂ' => 'a',
		'ἆ' => 'a',
		'ἁ' => 'a',
		'ἅ' => 'a',
		'ἃ' => 'a',
		'ἇ' => 'a',
		'β' => 'v',
		'γ' => 'g',
		'δ' => 'd',
		'ε' => 'e',
		'έ' => 'e',
		'ὲ' => 'e',
		'ἐ' => 'e',
		'ἔ' => 'e',
		'ἒ' => 'e',
		'ἑ' => 'e',
		'ἕ' => 'e',
		'ἓ' => 'e',
		'ζ' => 'z',
		'η' => 'i',
		'ή' => 'i',
		'ὴ' => 'i',
		'ἠ' => 'i',
		'ἤ' => 'i',
		'ἢ' => 'i',
		'ἦ' => 'i',
		'ἡ' => 'i',
		'ἥ' => 'i',
		'ἣ' => 'i',
		'ἧ' => 'i',
		'θ' => 'th',
		'ι' => 'i',
		'ί' => 'i',
		'ὶ' => 'i',
		'ῖ' => 'i',
		'ἰ' => 'i',
		'ἴ' => 'i',
		'ἲ' => 'i',
		'ἶ' => 'i',
		'ἱ' => 'i',
		'ἵ' => 'i',
		'ἳ' => 'i',
		'ἷ' => 'i',
		'ϊ' => 'i',
		'ΐ' => 'i',
		'κ' => 'k',
		'λ' => 'l',
		'μ' => 'm',
		'ν' => 'n',
		'ξ' => 'x',
		'ο' => 'o',
		'ό' => 'o',
		'ὸ' => 'o',
		'ὀ' => 'o',
		'ὄ' => 'o',
		'ὂ' => 'o',
		'ὁ' => 'o',
		'ὅ' => 'o',
		'ὃ' => 'o',
		'π' => 'p',
		'ρ' => 'r',
		'ῤ' => 'r',
		'ῥ' => 'r',
		'σ' => 's',
		'ς' => 's',
		'τ' => 't',
		'υ' => 'y',
		'ύ' => 'y',
		'ὺ' => 'y',
		'ῦ' => 'y',
		'ὐ' => 'y',
		'ὔ' => 'y',
		'ὒ' => 'y',
		'ὖ' => 'y',
		'ὑ' => 'y',
		'ὕ' => 'y',
		'ὓ' => 'y',
		'ὗ' => 'y',
		'ϋ' => 'y',
		'ΰ' => 'y',
		'φ' => 'f',
		'χ' => 'ch',
		'ψ' => 'ps',
		'ω' => 'o',
		'ώ' => 'o',
		'ὼ' => 'o',
		'ὠ' => 'o',
		'ὤ' => 'o',
		'ὢ' => 'o',
		'ὦ' => 'o',
		'ὡ' => 'o',
		'ὥ' => 'o',
		'ὣ' => 'o',
		'ὧ' => 'o',
		'Α' => 'A',
		'Ά' => 'A',
		'Β' => 'V',
		'Γ' => 'G',
		'Δ' => 'D',
		'Ε' => 'E',
		'Έ' => 'E',
		'Ζ' => 'Z',
		'Η' => 'I',
		'Ή' => 'I',
		'Θ' => 'Th',
		'Ι' => 'I',
		'Ί' => 'I',
		'Ϊ' => 'I',
		'Κ' => 'K',
		'Λ' => 'L',
		'Μ' => 'M',
		'Ν' => 'N',
		'Ξ' => 'X',
		'Ο' => 'O',
		'Ό' => 'O',
		'Π' => 'P',
		'Ρ' => 'R',
		'Σ' => 'S',
		'Τ' => 'T',
		'Υ' => 'Y',
		'Ύ' => 'Y',
		'Ϋ' => 'Y',
		'Φ' => 'F',
		'Χ' => 'Ch',
		'Ψ' => 'Ps',
		'Ω' => 'O',
		'Ώ' => 'O',
	];

	/** @var array ENTITY / DECODE */
	private array $_aHtmlEntities = [
		'&quot;' => '"',
		'&amp;' => '&',
		'&euro;' => '€',
		'&lt;' => '<',
		'&gt;' => '>',
		'&oelig;' => 'œ',
		'&Yuml;' => 'Ÿ',
		'&iexcl;' => '¡',
		'&cent;' => '¢',
		'&pound;' => '£',
		'&curren;' => '¤',
		'&yen;' => '¥',
		'&brvbar;' => '¦',
		'&sect;' => '§',
		'&uml;' => '¨',
		'&copy;' => '©',
		'&ordf;' => 'ª',
		'&laquo;' => '«',
		'&not;' => '¬',
		'&shy;' => '­',
		'&reg;' => '®',
		'&masr;' => '¯',
		'&deg;' => '°',
		'&plusmn;' => '±',
		'&sup2;' => '²',
		'&sup3;' => '³',
		'&acute;' => "'",
		'&micro;' => 'µ',
		'&para;' => '¶',
		'&middot;' => '·',
		'&cedil;' => '¸',
		'&sup1;' => '¹',
		'&ordm;' => 'º',
		'&raquo;' => '»',
		'&frac14;' => '¼',
		'&frac12;' => '½',
		'&frac34;' => '¾',
		'&iquest;' => '¿',
		'&Agrave;' => 'À',
		'&Aacute;' => 'Á',
		'&Acirc;' => 'Â',
		'&Atilde;' => 'Ã',
		'&Auml;' => 'Ä',
		'&Aring;' => 'Å',
		'&Aelig' => 'Æ',
		'&Ccedil;' => 'Ç',
		'&Egrave;' => 'È',
		'&Eacute;' => 'É',
		'&Ecirc;' => 'Ê',
		'&Euml;' => 'Ë',
		'&Igrave;' => 'Ì',
		'&Iacute;' => 'Í',
		'&Icirc;' => 'Î',
		'&Iuml;' => 'Ï',
		'&ETH;' => 'Ð',
		'&Ntilde;' => 'Ñ',
		'&Ograve;' => 'Ò',
		'&Oacute;' => 'Ó',
		'&Ocirc;' => 'Ô',
		'&Otilde;' => 'Õ',
		'&Ouml;' => 'Ö',
		'&times;' => '×',
		'&Oslash;' => 'Ø',
		'&Ugrave;' => 'Ù',
		'&Uacute;' => 'Ú',
		'&Ucirc;' => 'Û',
		'&Uuml;' => 'Ü',
		'&Yacute;' => 'Ý',
		'&THORN;' => 'Þ',
		'&szlig;' => 'ß',
		'&agrave;' => 'à',
		'&aacute;' => 'á',
		'&acirc;' => 'â',
		'&atilde;' => 'ã',
		'&auml;' => 'ä',
		'&aring;' => 'å',
		'&aelig;' => 'æ',
		'&ccedil;' => 'ç',
		'&egrave;' => 'è',
		'&eacute;' => 'é',
		'&ecirc;' => 'ê',
		'&euml;' => 'ë',
		'&igrave;' => 'ì',
		'&iacute;' => 'í',
		'&icirc;' => 'î',
		'&iuml;' => 'ï',
		'&eth;' => 'ð',
		'&ntilde;' => 'ñ',
		'&ograve;' => 'ò',
		'&oacute;' => 'ó',
		'&ocirc;' => 'ô',
		'&otilde;' => 'õ',
		'&ouml;' => 'ö',
		'&divide;' => '÷',
		'&oslash;' => 'ø',
		'&ugrave;' => 'ù',
		'&uacute;' => 'ú',
		'&ucirc;' => 'û',
		'&uuml;' => 'ü',
		'&yacute;' => 'ý',
		'&thorn;' => 'þ',
		'&yuml;' => 'ÿ',
		'&lsquo;' => '‘',
		'&rsquo;' => '’',
		'&sbquo;' => '‚',
		'&ldquo;' => '“',
		'&rdquo;' => '”',
		'&bdquo;' => '„',
		'&dagger;' => '†',
		'&Dagger;' => '‡',
		'&permil;' => '‰',
		'&lsaquo;' => '‹',
		'&rsaquo;' => '›',
		'&spades;' => '♠',
		'&clubs;' => '♣',
		'&hearts;' => '♥',
		'&diams;' => '♦',
		'&oline;' => '‾',
		'&larr;' => '←',
		'&uarr;' => '↑',
		'&rarr;' => '→',
		'&darr;' => '↓',
		'&trade;' => '™',
		'&frasl;' => '/',
		'&hellip;' => '…',
		'&ndash;' => '–',
		'&mdash;' => '—',
		'&brkbar;' => '¦',
		'&die;' => '¨',
		'&macr;' => '¯',
		'&hibar;' => '¯',
		'&Alpha;' => 'Α',
		'&alpha;' => 'α',
		'&Beta;' => 'Β',
		'&beta;' => 'β',
		'&Gamma;' => 'Γ',
		'&gamma;' => 'γ',
		'&Delta;' => 'Δ',
		'&delta;' => 'δ',
		'&Epsilon;' => 'Ε',
		'&epsilon;' => 'ε',
		'&Zeta;' => 'Ζ',
		'&zeta;' => 'ζ',
		'&Eta;' => 'Η',
		'&eta;' => 'η',
		'&Theta;' => 'Θ',
		'&theta;' => 'θ',
		'&Iota;' => 'Ι',
		'&iota;' => 'ι',
		'&Kappa;' => 'Κ',
		'&kappa;' => 'κ',
		'&Lambda;' => 'Λ',
		'&lambda;' => 'λ',
		'&Mu;' => 'Μ',
		'&mu;' => 'μ',
		'&Nu;' => 'Ν',
		'&nu;' => 'ν',
		'&Xi;' => 'Ξ',
		'&xi;' => 'ξ',
		'&Omicron;' => 'Ο',
		'&omicron;' => 'ο',
		'&Pi;' => 'Π',
		'&pi;' => 'π',
		'&Rho;' => 'Ρ',
		'&rho;' => 'ρ',
		'&Sigma;' => 'Σ',
		'&sigma;' => 'σ',
		'&Tau;' => 'Τ',
		'&tau;' => 'τ',
		'&Upsilon;' => 'Υ',
		'&upsilon;' => 'υ',
		'&Phi;' => 'Φ',
		'&phi;' => 'φ',
		'&Chi;' => 'Χ',
		'&chi;' => 'χ',
		'&Psi;' => 'Ψ',
		'&psi;' => 'ψ',
		'&Omega;' => 'Ω',
		'&omega;' => 'ω',
	];
	private $_aIsoCode = [
		'&#33;' => '!',
		'&#34;' => '"',
		'&#35;' => '#',
		'&#36;' => '$',
		'&#37;' => '%',
		'&#38;' => '&',
		'&#39;' => "'",
		'&#40;' => '(',
		'&#41;' => ')',
		'&#42;' => '*',
		'&#43;' => '+',
		'&#44;' => ',',
		'&#45;' => '-',
		'&#46;' => '.',
		'&#47;' => '/',
		'&#48;' => '0',
		'&#49;' => '1',
		'&#50;' => '2',
		'&#51;' => '3',
		'&#52;' => '4',
		'&#53;' => '5',
		'&#54;' => '6',
		'&#55;' => '7',
		'&#56;' => '8',
		'&#57;' => '9',
		'&#58;' => ':',
		'&#59;' => ';',
		'&#60;' => '<',
		'&#61;' => '=',
		'&#62;' => '>',
		'&#63;' => '?',
		'&#64;' => '@',
		'&#65;' => 'A',
		'&#66;' => 'B',
		'&#67;' => 'C',
		'&#68;' => 'D',
		'&#69;' => 'E',
		'&#70;' => 'F',
		'&#71;' => 'G',
		'&#72;' => 'H',
		'&#73;' => 'I',
		'&#74;' => 'J',
		'&#75;' => 'K',
		'&#76;' => 'L',
		'&#77;' => 'M',
		'&#78;' => 'N',
		'&#79;' => 'O',
		'&#80;' => 'P',
		'&#81;' => 'Q',
		'&#82;' => 'R',
		'&#83;' => 'S',
		'&#84;' => 'T',
		'&#85;' => 'U',
		'&#86;' => 'V',
		'&#87;' => 'W',
		'&#88;' => 'X',
		'&#89;' => 'Y',
		'&#90;' => 'Z',
		'&#91;' => '[',
		'&#92;' => '\\',
		'&#93;' => ']',
		'&#94;' => '^',
		'&#95;' => '_',
		'&#96;' => '`',
		'&#97;' => 'a',
		'&#98;' => 'b',
		'&#99;' => 'c',
		'&#100;' => 'd',
		'&#101;' => 'e',
		'&#102;' => 'f',
		'&#103;' => 'g',
		'&#104;' => 'h',
		'&#105;' => 'i',
		'&#106;' => 'j',
		'&#107;' => 'k',
		'&#108;' => 'l',
		'&#109;' => 'm',
		'&#110;' => 'n',
		'&#111;' => 'o',
		'&#112;' => 'p',
		'&#113;' => 'q',
		'&#114;' => 'r',
		'&#115;' => 's',
		'&#116;' => 't',
		'&#117;' => 'u',
		'&#118;' => 'v',
		'&#119;' => 'w',
		'&#120;' => 'x',
		'&#121;' => 'y',
		'&#122;' => 'z',
		'&#123;' => '{',
		'&#124;' => '|',
		'&#125;' => '}',
		'&#126;' => '~',
		'&#128;' => '€',
		'&#130;' => "'",
		'&#131;' => 'ƒ',
		'&#132;' => '"',
		'&#133;' => '…',
		'&#134;' => '+',
		'&#135;' => '#',
		'&#136;' => '^',
		'&#137;' => '‰',
		'&#138;' => 'Š',
		'&#139;' => '<',
		'&#140;' => 'Œ',
		'&#142;' => 'Z',
		'&#145;' => "'",
		'&#146;' => "'",
		'&#147;' => '"',
		'&#148;' => '"',
		'&#149;' => '*',
		'&#150;' => '-',
		'&#151;' => '—',
		'&#152;' => '~',
		'&#153;' => '™',
		'&#154;' => 'š',
		'&#155;' => '>',
		'&#156;' => 'œ',
		'&#158;' => 'z',
		'&#159;' => 'Y',
		'&#161;' => '¡',
		'&#162;' => '¢',
		'&#163;' => '£',
		'&#164;' => '¤',
		'&#165;' => '¥',
		'&#166;' => '¦',
		'&#167;' => '§',
		'&#168;' => '¨',
		'&#169;' => '©',
		'&#170;' => 'ª',
		'&#171;' => '«',
		'&#172;' => '¬',
		'&#173;' => '­',
		'&#174;' => '®',
		'&#175;' => '¯',
		'&#176;' => '°',
		'&#177;' => '±',
		'&#178;' => '²',
		'&#179;' => '³',
		'&#180;' => "'",
		'&#181;' => 'µ',
		'&#182;' => '¶',
		'&#183;' => '·',
		'&#184;' => '¸',
		'&#185;' => '¹',
		'&#186;' => 'º',
		'&#187;' => '»',
		'&#188;' => '¼',
		'&#189;' => '½',
		'&#190;' => '¾',
		'&#191;' => '¿',
		'&#192;' => 'À',
		'&#193;' => 'Á',
		'&#194;' => 'Â',
		'&#195;' => 'Ã',
		'&#196;' => 'Ä',
		'&#197;' => 'Å',
		'&#198;' => 'Æ',
		'&#199;' => 'Ç',
		'&#200;' => 'È',
		'&#201;' => 'É',
		'&#202;' => 'Ê',
		'&#203;' => 'Ë',
		'&#204;' => 'Ì',
		'&#205;' => 'Í',
		'&#206;' => 'Î',
		'&#207;' => 'Ï',
		'&#208;' => 'Ð',
		'&#209;' => 'Ñ',
		'&#210;' => 'Ò',
		'&#211;' => 'Ó',
		'&#212;' => 'Ô',
		'&#213;' => 'Õ',
		'&#214;' => 'Ö',
		'&#215;' => '×',
		'&#216;' => 'Ø',
		'&#217;' => 'Ù',
		'&#218;' => 'Ú',
		'&#219;' => 'Û',
		'&#220;' => 'Ü',
		'&#221;' => 'Ý',
		'&#222;' => 'Þ',
		'&#223;' => 'ß',
		'&#7838;' => 'ẞ',
		'&#224;' => 'à',
		'&#225;' => 'á',
		'&#226;' => 'â',
		'&#227;' => 'ã',
		'&#228;' => 'ä',
		'&#229;' => 'å',
		'&#230;' => 'æ',
		'&#231;' => 'ç',
		'&#232;' => 'è',
		'&#233;' => 'é',
		'&#234;' => 'ê',
		'&#235;' => 'ë',
		'&#236;' => 'ì',
		'&#237;' => 'í',
		'&#238;' => 'î',
		'&#239;' => 'ï',
		'&#240;' => 'ð',
		'&#241;' => 'ñ',
		'&#242;' => 'ò',
		'&#243;' => 'ó',
		'&#244;' => 'ô',
		'&#245;' => 'õ',
		'&#246;' => 'ö',
		'&#247;' => '÷',
		'&#248;' => 'ø',
		'&#249;' => 'ù',
		'&#250;' => 'ú',
		'&#251;' => 'û',
		'&#252;' => 'ü',
		'&#253;' => 'ý',
		'&#254;' => 'þ',
		'&#255;' => 'ÿ',
		'&#9679;' => '●',
		'&#8226;' => '•',
	];

	/**
	 * @link https://stackoverflow.com/questions/11176752/converting-named-html-entities-to-numeric-html-entities
	 */
	private $_namedToNumeric = [
		'&nbsp;'     => '&#160;',  # no-break space = non-breaking space, U+00A0 ISOnum
		'&iexcl;'    => '&#161;',  # inverted exclamation mark, U+00A1 ISOnum
		'&cent;'     => '&#162;',  # cent sign, U+00A2 ISOnum
		'&pound;'    => '&#163;',  # pound sign, U+00A3 ISOnum
		'&curren;'   => '&#164;',  # currency sign, U+00A4 ISOnum
		'&yen;'      => '&#165;',  # yen sign = yuan sign, U+00A5 ISOnum
		'&brvbar;'   => '&#166;',  # broken bar = broken vertical bar, U+00A6 ISOnum
		'&sect;'     => '&#167;',  # section sign, U+00A7 ISOnum
		'&uml;'      => '&#168;',  # diaeresis = spacing diaeresis, U+00A8 ISOdia
		'&copy;'     => '&#169;',  # copyright sign, U+00A9 ISOnum
		'&ordf;'     => '&#170;',  # feminine ordinal indicator, U+00AA ISOnum
		'&laquo;'    => '&#171;',  # left-pointing double angle quotation mark = left pointing guillemet, U+00AB ISOnum
		'&not;'      => '&#172;',  # not sign, U+00AC ISOnum
		'&shy;'      => '&#173;',  # soft hyphen = discretionary hyphen, U+00AD ISOnum
		'&reg;'      => '&#174;',  # registered sign = registered trade mark sign, U+00AE ISOnum
		'&macr;'     => '&#175;',  # macron = spacing macron = overline = APL overbar, U+00AF ISOdia
		'&deg;'      => '&#176;',  # degree sign, U+00B0 ISOnum
		'&plusmn;'   => '&#177;',  # plus-minus sign = plus-or-minus sign, U+00B1 ISOnum
		'&sup2;'     => '&#178;',  # superscript two = superscript digit two = squared, U+00B2 ISOnum
		'&sup3;'     => '&#179;',  # superscript three = superscript digit three = cubed, U+00B3 ISOnum
		'&acute;'    => '&#180;',  # acute accent = spacing acute, U+00B4 ISOdia
		'&micro;'    => '&#181;',  # micro sign, U+00B5 ISOnum
		'&para;'     => '&#182;',  # pilcrow sign = paragraph sign, U+00B6 ISOnum
		'&middot;'   => '&#183;',  # middle dot = Georgian comma = Greek middle dot, U+00B7 ISOnum
		'&cedil;'    => '&#184;',  # cedilla = spacing cedilla, U+00B8 ISOdia
		'&sup1;'     => '&#185;',  # superscript one = superscript digit one, U+00B9 ISOnum
		'&ordm;'     => '&#186;',  # masculine ordinal indicator, U+00BA ISOnum
		'&raquo;'    => '&#187;',  # right-pointing double angle quotation mark = right pointing guillemet, U+00BB ISOnum
		'&frac14;'   => '&#188;',  # vulgar fraction one quarter = fraction one quarter, U+00BC ISOnum
		'&frac12;'   => '&#189;',  # vulgar fraction one half = fraction one half, U+00BD ISOnum
		'&frac34;'   => '&#190;',  # vulgar fraction three quarters = fraction three quarters, U+00BE ISOnum
		'&iquest;'   => '&#191;',  # inverted question mark = turned question mark, U+00BF ISOnum
		'&Agrave;'   => '&#192;',  # latin capital letter A with grave = latin capital letter A grave, U+00C0 ISOlat1
		'&Aacute;'   => '&#193;',  # latin capital letter A with acute, U+00C1 ISOlat1
		'&Acirc;'    => '&#194;',  # latin capital letter A with circumflex, U+00C2 ISOlat1
		'&Atilde;'   => '&#195;',  # latin capital letter A with tilde, U+00C3 ISOlat1
		'&Auml;'     => '&#196;',  # latin capital letter A with diaeresis, U+00C4 ISOlat1
		'&Aring;'    => '&#197;',  # latin capital letter A with ring above = latin capital letter A ring, U+00C5 ISOlat1
		'&AElig;'    => '&#198;',  # latin capital letter AE = latin capital ligature AE, U+00C6 ISOlat1
		'&Ccedil;'   => '&#199;',  # latin capital letter C with cedilla, U+00C7 ISOlat1
		'&Egrave;'   => '&#200;',  # latin capital letter E with grave, U+00C8 ISOlat1
		'&Eacute;'   => '&#201;',  # latin capital letter E with acute, U+00C9 ISOlat1
		'&Ecirc;'    => '&#202;',  # latin capital letter E with circumflex, U+00CA ISOlat1
		'&Euml;'     => '&#203;',  # latin capital letter E with diaeresis, U+00CB ISOlat1
		'&Igrave;'   => '&#204;',  # latin capital letter I with grave, U+00CC ISOlat1
		'&Iacute;'   => '&#205;',  # latin capital letter I with acute, U+00CD ISOlat1
		'&Icirc;'    => '&#206;',  # latin capital letter I with circumflex, U+00CE ISOlat1
		'&Iuml;'     => '&#207;',  # latin capital letter I with diaeresis, U+00CF ISOlat1
		'&ETH;'      => '&#208;',  # latin capital letter ETH, U+00D0 ISOlat1
		'&Ntilde;'   => '&#209;',  # latin capital letter N with tilde, U+00D1 ISOlat1
		'&Ograve;'   => '&#210;',  # latin capital letter O with grave, U+00D2 ISOlat1
		'&Oacute;'   => '&#211;',  # latin capital letter O with acute, U+00D3 ISOlat1
		'&Ocirc;'    => '&#212;',  # latin capital letter O with circumflex, U+00D4 ISOlat1
		'&Otilde;'   => '&#213;',  # latin capital letter O with tilde, U+00D5 ISOlat1
		'&Ouml;'     => '&#214;',  # latin capital letter O with diaeresis, U+00D6 ISOlat1
		'&times;'    => '&#215;',  # multiplication sign, U+00D7 ISOnum
		'&Oslash;'   => '&#216;',  # latin capital letter O with stroke = latin capital letter O slash, U+00D8 ISOlat1
		'&Ugrave;'   => '&#217;',  # latin capital letter U with grave, U+00D9 ISOlat1
		'&Uacute;'   => '&#218;',  # latin capital letter U with acute, U+00DA ISOlat1
		'&Ucirc;'    => '&#219;',  # latin capital letter U with circumflex, U+00DB ISOlat1
		'&Uuml;'     => '&#220;',  # latin capital letter U with diaeresis, U+00DC ISOlat1
		'&Yacute;'   => '&#221;',  # latin capital letter Y with acute, U+00DD ISOlat1
		'&THORN;'    => '&#222;',  # latin capital letter THORN, U+00DE ISOlat1
		'&szlig;'    => '&#223;',  # latin small letter sharp s = ess-zed, U+00DF ISOlat1
		'&agrave;'   => '&#224;',  # latin small letter a with grave = latin small letter a grave, U+00E0 ISOlat1
		'&aacute;'   => '&#225;',  # latin small letter a with acute, U+00E1 ISOlat1
		'&acirc;'    => '&#226;',  # latin small letter a with circumflex, U+00E2 ISOlat1
		'&atilde;'   => '&#227;',  # latin small letter a with tilde, U+00E3 ISOlat1
		'&auml;'     => '&#228;',  # latin small letter a with diaeresis, U+00E4 ISOlat1
		'&aring;'    => '&#229;',  # latin small letter a with ring above = latin small letter a ring, U+00E5 ISOlat1
		'&aelig;'    => '&#230;',  # latin small letter ae = latin small ligature ae, U+00E6 ISOlat1
		'&ccedil;'   => '&#231;',  # latin small letter c with cedilla, U+00E7 ISOlat1
		'&egrave;'   => '&#232;',  # latin small letter e with grave, U+00E8 ISOlat1
		'&eacute;'   => '&#233;',  # latin small letter e with acute, U+00E9 ISOlat1
		'&ecirc;'    => '&#234;',  # latin small letter e with circumflex, U+00EA ISOlat1
		'&euml;'     => '&#235;',  # latin small letter e with diaeresis, U+00EB ISOlat1
		'&igrave;'   => '&#236;',  # latin small letter i with grave, U+00EC ISOlat1
		'&iacute;'   => '&#237;',  # latin small letter i with acute, U+00ED ISOlat1
		'&icirc;'    => '&#238;',  # latin small letter i with circumflex, U+00EE ISOlat1
		'&iuml;'     => '&#239;',  # latin small letter i with diaeresis, U+00EF ISOlat1
		'&eth;'      => '&#240;',  # latin small letter eth, U+00F0 ISOlat1
		'&ntilde;'   => '&#241;',  # latin small letter n with tilde, U+00F1 ISOlat1
		'&ograve;'   => '&#242;',  # latin small letter o with grave, U+00F2 ISOlat1
		'&oacute;'   => '&#243;',  # latin small letter o with acute, U+00F3 ISOlat1
		'&ocirc;'    => '&#244;',  # latin small letter o with circumflex, U+00F4 ISOlat1
		'&otilde;'   => '&#245;',  # latin small letter o with tilde, U+00F5 ISOlat1
		'&ouml;'     => '&#246;',  # latin small letter o with diaeresis, U+00F6 ISOlat1
		'&divide;'   => '&#247;',  # division sign, U+00F7 ISOnum
		'&oslash;'   => '&#248;',  # latin small letter o with stroke, = latin small letter o slash, U+00F8 ISOlat1
		'&ugrave;'   => '&#249;',  # latin small letter u with grave, U+00F9 ISOlat1
		'&uacute;'   => '&#250;',  # latin small letter u with acute, U+00FA ISOlat1
		'&ucirc;'    => '&#251;',  # latin small letter u with circumflex, U+00FB ISOlat1
		'&uuml;'     => '&#252;',  # latin small letter u with diaeresis, U+00FC ISOlat1
		'&yacute;'   => '&#253;',  # latin small letter y with acute, U+00FD ISOlat1
		'&thorn;'    => '&#254;',  # latin small letter thorn, U+00FE ISOlat1
		'&yuml;'     => '&#255;',  # latin small letter y with diaeresis, U+00FF ISOlat1
		'&fnof;'     => '&#402;',  # latin small f with hook = function = florin, U+0192 ISOtech
		'&Alpha;'    => '&#913;',  # greek capital letter alpha, U+0391
		'&Beta;'     => '&#914;',  # greek capital letter beta, U+0392
		'&Gamma;'    => '&#915;',  # greek capital letter gamma, U+0393 ISOgrk3
		'&Delta;'    => '&#916;',  # greek capital letter delta, U+0394 ISOgrk3
		'&Epsilon;'  => '&#917;',  # greek capital letter epsilon, U+0395
		'&Zeta;'     => '&#918;',  # greek capital letter zeta, U+0396
		'&Eta;'      => '&#919;',  # greek capital letter eta, U+0397
		'&Theta;'    => '&#920;',  # greek capital letter theta, U+0398 ISOgrk3
		'&Iota;'     => '&#921;',  # greek capital letter iota, U+0399
		'&Kappa;'    => '&#922;',  # greek capital letter kappa, U+039A
		'&Lambda;'   => '&#923;',  # greek capital letter lambda, U+039B ISOgrk3
		'&Mu;'       => '&#924;',  # greek capital letter mu, U+039C
		'&Nu;'       => '&#925;',  # greek capital letter nu, U+039D
		'&Xi;'       => '&#926;',  # greek capital letter xi, U+039E ISOgrk3
		'&Omicron;'  => '&#927;',  # greek capital letter omicron, U+039F
		'&Pi;'       => '&#928;',  # greek capital letter pi, U+03A0 ISOgrk3
		'&Rho;'      => '&#929;',  # greek capital letter rho, U+03A1
		'&Sigma;'    => '&#931;',  # greek capital letter sigma, U+03A3 ISOgrk3
		'&Tau;'      => '&#932;',  # greek capital letter tau, U+03A4
		'&Upsilon;'  => '&#933;',  # greek capital letter upsilon, U+03A5 ISOgrk3
		'&Phi;'      => '&#934;',  # greek capital letter phi, U+03A6 ISOgrk3
		'&Chi;'      => '&#935;',  # greek capital letter chi, U+03A7
		'&Psi;'      => '&#936;',  # greek capital letter psi, U+03A8 ISOgrk3
		'&Omega;'    => '&#937;',  # greek capital letter omega, U+03A9 ISOgrk3
		'&alpha;'    => '&#945;',  # greek small letter alpha, U+03B1 ISOgrk3
		'&beta;'     => '&#946;',  # greek small letter beta, U+03B2 ISOgrk3
		'&gamma;'    => '&#947;',  # greek small letter gamma, U+03B3 ISOgrk3
		'&delta;'    => '&#948;',  # greek small letter delta, U+03B4 ISOgrk3
		'&epsilon;'  => '&#949;',  # greek small letter epsilon, U+03B5 ISOgrk3
		'&zeta;'     => '&#950;',  # greek small letter zeta, U+03B6 ISOgrk3
		'&eta;'      => '&#951;',  # greek small letter eta, U+03B7 ISOgrk3
		'&theta;'    => '&#952;',  # greek small letter theta, U+03B8 ISOgrk3
		'&iota;'     => '&#953;',  # greek small letter iota, U+03B9 ISOgrk3
		'&kappa;'    => '&#954;',  # greek small letter kappa, U+03BA ISOgrk3
		'&lambda;'   => '&#955;',  # greek small letter lambda, U+03BB ISOgrk3
		'&mu;'       => '&#956;',  # greek small letter mu, U+03BC ISOgrk3
		'&nu;'       => '&#957;',  # greek small letter nu, U+03BD ISOgrk3
		'&xi;'       => '&#958;',  # greek small letter xi, U+03BE ISOgrk3
		'&omicron;'  => '&#959;',  # greek small letter omicron, U+03BF NEW
		'&pi;'       => '&#960;',  # greek small letter pi, U+03C0 ISOgrk3
		'&rho;'      => '&#961;',  # greek small letter rho, U+03C1 ISOgrk3
		'&sigmaf;'   => '&#962;',  # greek small letter final sigma, U+03C2 ISOgrk3
		'&sigma;'    => '&#963;',  # greek small letter sigma, U+03C3 ISOgrk3
		'&tau;'      => '&#964;',  # greek small letter tau, U+03C4 ISOgrk3
		'&upsilon;'  => '&#965;',  # greek small letter upsilon, U+03C5 ISOgrk3
		'&phi;'      => '&#966;',  # greek small letter phi, U+03C6 ISOgrk3
		'&chi;'      => '&#967;',  # greek small letter chi, U+03C7 ISOgrk3
		'&psi;'      => '&#968;',  # greek small letter psi, U+03C8 ISOgrk3
		'&omega;'    => '&#969;',  # greek small letter omega, U+03C9 ISOgrk3
		'&thetasym;' => '&#977;',  # greek small letter theta symbol, U+03D1 NEW
		'&upsih;'    => '&#978;',  # greek upsilon with hook symbol, U+03D2 NEW
		'&piv;'      => '&#982;',  # greek pi symbol, U+03D6 ISOgrk3
		'&bull;'     => '&#8226;', # bullet = black small circle, U+2022 ISOpub
		'&hellip;'   => '&#8230;', # horizontal ellipsis = three dot leader, U+2026 ISOpub
		'&prime;'    => '&#8242;', # prime = minutes = feet, U+2032 ISOtech
		'&Prime;'    => '&#8243;', # double prime = seconds = inches, U+2033 ISOtech
		'&oline;'    => '&#8254;', # overline = spacing overscore, U+203E NEW
		'&frasl;'    => '&#8260;', # fraction slash, U+2044 NEW
		'&weierp;'   => '&#8472;', # script capital P = power set = Weierstrass p, U+2118 ISOamso
		'&image;'    => '&#8465;', # blackletter capital I = imaginary part, U+2111 ISOamso
		'&real;'     => '&#8476;', # blackletter capital R = real part symbol, U+211C ISOamso
		'&trade;'    => '&#8482;', # trade mark sign, U+2122 ISOnum
		'&alefsym;'  => '&#8501;', # alef symbol = first transfinite cardinal, U+2135 NEW
		'&larr;'     => '&#8592;', # leftwards arrow, U+2190 ISOnum
		'&uarr;'     => '&#8593;', # upwards arrow, U+2191 ISOnum
		'&rarr;'     => '&#8594;', # rightwards arrow, U+2192 ISOnum
		'&darr;'     => '&#8595;', # downwards arrow, U+2193 ISOnum
		'&harr;'     => '&#8596;', # left right arrow, U+2194 ISOamsa
		'&crarr;'    => '&#8629;', # downwards arrow with corner leftwards = carriage return, U+21B5 NEW
		'&lArr;'     => '&#8656;', # leftwards double arrow, U+21D0 ISOtech
		'&uArr;'     => '&#8657;', # upwards double arrow, U+21D1 ISOamsa
		'&rArr;'     => '&#8658;', # rightwards double arrow, U+21D2 ISOtech
		'&dArr;'     => '&#8659;', # downwards double arrow, U+21D3 ISOamsa
		'&hArr;'     => '&#8660;', # left right double arrow, U+21D4 ISOamsa
		'&forall;'   => '&#8704;', # for all, U+2200 ISOtech
		'&part;'     => '&#8706;', # partial differential, U+2202 ISOtech
		'&exist;'    => '&#8707;', # there exists, U+2203 ISOtech
		'&empty;'    => '&#8709;', # empty set = null set = diameter, U+2205 ISOamso
		'&nabla;'    => '&#8711;', # nabla = backward difference, U+2207 ISOtech
		'&isin;'     => '&#8712;', # element of, U+2208 ISOtech
		'&notin;'    => '&#8713;', # not an element of, U+2209 ISOtech
		'&ni;'       => '&#8715;', # contains as member, U+220B ISOtech
		'&prod;'     => '&#8719;', # n-ary product = product sign, U+220F ISOamsb
		'&sum;'      => '&#8721;', # n-ary sumation, U+2211 ISOamsb
		'&minus;'    => '&#8722;', # minus sign, U+2212 ISOtech
		'&lowast;'   => '&#8727;', # asterisk operator, U+2217 ISOtech
		'&radic;'    => '&#8730;', # square root = radical sign, U+221A ISOtech
		'&prop;'     => '&#8733;', # proportional to, U+221D ISOtech
		'&infin;'    => '&#8734;', # infinity, U+221E ISOtech
		'&ang;'      => '&#8736;', # angle, U+2220 ISOamso
		'&and;'      => '&#8743;', # logical and = wedge, U+2227 ISOtech
		'&or;'       => '&#8744;', # logical or = vee, U+2228 ISOtech
		'&cap;'      => '&#8745;', # intersection = cap, U+2229 ISOtech
		'&cup;'      => '&#8746;', # union = cup, U+222A ISOtech
		'&int;'      => '&#8747;', # integral, U+222B ISOtech
		'&there4;'   => '&#8756;', # therefore, U+2234 ISOtech
		'&sim;'      => '&#8764;', # tilde operator = varies with = similar to, U+223C ISOtech
		'&cong;'     => '&#8773;', # approximately equal to, U+2245 ISOtech
		'&asymp;'    => '&#8776;', # almost equal to = asymptotic to, U+2248 ISOamsr
		'&ne;'       => '&#8800;', # not equal to, U+2260 ISOtech
		'&equiv;'    => '&#8801;', # identical to, U+2261 ISOtech
		'&le;'       => '&#8804;', # less-than or equal to, U+2264 ISOtech
		'&ge;'       => '&#8805;', # greater-than or equal to, U+2265 ISOtech
		'&sub;'      => '&#8834;', # subset of, U+2282 ISOtech
		'&sup;'      => '&#8835;', # superset of, U+2283 ISOtech
		'&nsub;'     => '&#8836;', # not a subset of, U+2284 ISOamsn
		'&sube;'     => '&#8838;', # subset of or equal to, U+2286 ISOtech
		'&supe;'     => '&#8839;', # superset of or equal to, U+2287 ISOtech
		'&oplus;'    => '&#8853;', # circled plus = direct sum, U+2295 ISOamsb
		'&otimes;'   => '&#8855;', # circled times = vector product, U+2297 ISOamsb
		'&perp;'     => '&#8869;', # up tack = orthogonal to = perpendicular, U+22A5 ISOtech
		'&sdot;'     => '&#8901;', # dot operator, U+22C5 ISOamsb
		'&lceil;'    => '&#8968;', # left ceiling = apl upstile, U+2308 ISOamsc
		'&rceil;'    => '&#8969;', # right ceiling, U+2309 ISOamsc
		'&lfloor;'   => '&#8970;', # left floor = apl downstile, U+230A ISOamsc
		'&rfloor;'   => '&#8971;', # right floor, U+230B ISOamsc
		'&lang;'     => '&#9001;', # left-pointing angle bracket = bra, U+2329 ISOtech
		'&rang;'     => '&#9002;', # right-pointing angle bracket = ket, U+232A ISOtech
		'&loz;'      => '&#9674;', # lozenge, U+25CA ISOpub
		'&spades;'   => '&#9824;', # black spade suit, U+2660 ISOpub
		'&clubs;'    => '&#9827;', # black club suit = shamrock, U+2663 ISOpub
		'&hearts;'   => '&#9829;', # black heart suit = valentine, U+2665 ISOpub
		'&diams;'    => '&#9830;', # black diamond suit, U+2666 ISOpub
		'&quot;'     => '&#34;',   # quotation mark = APL quote, U+0022 ISOnum
		'&amp;'      => '&#38;',   # ampersand, U+0026 ISOnum
		'&lt;'       => '&#60;',   # less-than sign, U+003C ISOnum
		'&gt;'       => '&#62;',   # greater-than sign, U+003E ISOnum
		'&OElig;'    => '&#338;',  # latin capital ligature OE, U+0152 ISOlat2
		'&oelig;'    => '&#339;',  # latin small ligature oe, U+0153 ISOlat2
		'&Scaron;'   => '&#352;',  # latin capital letter S with caron, U+0160 ISOlat2
		'&scaron;'   => '&#353;',  # latin small letter s with caron, U+0161 ISOlat2
		'&Yuml;'     => '&#376;',  # latin capital letter Y with diaeresis, U+0178 ISOlat2
		'&circ;'     => '&#710;',  # modifier letter circumflex accent, U+02C6 ISOpub
		'&tilde;'    => '&#732;',  # small tilde, U+02DC ISOdia
		'&ensp;'     => '&#8194;', # en space, U+2002 ISOpub
		'&emsp;'     => '&#8195;', # em space, U+2003 ISOpub
		'&thinsp;'   => '&#8201;', # thin space, U+2009 ISOpub
		'&zwnj;'     => '&#8204;', # zero width non-joiner, U+200C NEW RFC 2070
		'&zwj;'      => '&#8205;', # zero width joiner, U+200D NEW RFC 2070
		'&lrm;'      => '&#8206;', # left-to-right mark, U+200E NEW RFC 2070
		'&rlm;'      => '&#8207;', # right-to-left mark, U+200F NEW RFC 2070
		'&ndash;'    => '&#8211;', # en dash, U+2013 ISOpub
		'&mdash;'    => '&#8212;', # em dash, U+2014 ISOpub
		'&lsquo;'    => '&#8216;', # left single quotation mark, U+2018 ISOnum
		'&rsquo;'    => '&#8217;', # right single quotation mark, U+2019 ISOnum
		'&sbquo;'    => '&#8218;', # single low-9 quotation mark, U+201A NEW
		'&ldquo;'    => '&#8220;', # left double quotation mark, U+201C ISOnum
		'&rdquo;'    => '&#8221;', # right double quotation mark, U+201D ISOnum
		'&bdquo;'    => '&#8222;', # double low-9 quotation mark, U+201E NEW
		'&dagger;'   => '&#8224;', # dagger, U+2020 ISOpub
		'&Dagger;'   => '&#8225;', # double dagger, U+2021 ISOpub
		'&permil;'   => '&#8240;', # per mille sign, U+2030 ISOtech
		'&lsaquo;'   => '&#8249;', # single left-pointing angle quotation mark, U+2039 ISO proposed
		'&rsaquo;'   => '&#8250;', # single right-pointing angle quotation mark, U+203A ISO proposed
		'&euro;'     => '&#8364;', # euro sign, U+20AC NEW
		'&apos;'     => '&#39;',   # apostrophe = APL quote, U+0027 ISOnum
	];

	/**
	 * Converts named HTML entities to XML numeric entities (decimal).
	 *
	 * @param string $str The string to convert.
	 * @param bool $unescape If true, unescape entities before conversion.
	 * @return string The string with the entities converted to numeric format.
	 */
	public function convertToNumericEntities(string $str, bool $unescape = false): string
	{
		$escapedEntitiesToRestore = [];

		if ($unescape) {
			$str = html_entity_decode($str, ENT_NOQUOTES | ENT_HTML5, 'UTF-8');

			# Convert non-ASCII characters (like € or non-breaking space) to decimal.
			$str = mb_encode_numericentity($str, [0xA0, 0xffff, 0, 0xffff], 'UTF-8');

			# Convert reserved ASCII characters (< and >) that are not entities.
			$str = str_replace(
				['<', '>'],
				['&#60;', '&#62;'],
				$str
			);
		}
		else {
			# Hides escapes to be preserved (eg: &amp;nbsp; MUST remain &amp;nbsp;)
			$str = preg_replace_callback(
				'/(&amp;(?:nbsp|lt|gt|quot|apos|copy);)/i',
				function (array $matches) use (&$escapedEntitiesToRestore) {
					$token = '__ESCAPED_PRESERVED_' . mb_strtoupper(md5($matches[0])) . '__';
					$escapedEntitiesToRestore[$token] = $matches[0];
					return $token;
				},
				$str
			);
		}

		# Converting remaining named entities (including &amp; and &NBSP;)
		$converted_str = preg_replace_callback(
			'/&([a-zA-Z][a-zA-Z0-9]*|#[0-9]+|#x[0-9a-fA-F]+);/i',
			function (array $matches): string {
				$entity = $matches[0];

				# Numeric entities (&#...; or &#x...;): Returned intact.
				if (str_starts_with($entity, '&#')) {
					return $entity;
				}

				# Case correction: Force entity to lowercase for decoding
				$target_entity = strtolower($entity);

				# Decodes the named entity into a real character (Ex: &amp; -> &, &nbsp; -> U+00A0)
				$decoded = html_entity_decode($target_entity, ENT_NOQUOTES | ENT_HTML5, 'UTF-8');

				if (mb_strlen($decoded, 'UTF-8') === 1 && $decoded !== $target_entity) {
					$ord = mb_ord($decoded, 'UTF-8');
					return '&#' . $ord . ';';
				}
				return $matches[0];
			},
			$str
		);

		# Restoration of masked escapes
		if (!$unescape && $escapedEntitiesToRestore) {
			$converted_str = str_replace(array_keys($escapedEntitiesToRestore), array_values($escapedEntitiesToRestore), $converted_str);
		}
		return $converted_str;
	}

	/**
	 * Convert numerical entities to equivalent html named entities
	 *
	 * @param string $str
	 * @return string
	 */
	public function replaceHtmlEntitiesToUnicode(string $str): string
	{
		return preg_replace_callback('`&[a-z]+;`i', function ($matches) {
			$entity = strtolower($matches[0]);
			return $this->_namedToNumeric[$entity] ?? $matches[0];
		}, $str);
		//return strtr($str, $this->_namedToNumeric);
	}

	/**
	 * Convert numerical entities to equivalent html named entities
	 *
	 * @param string $str
	 * @return string
	 */
	public function replaceUnicodeToHtmlEntities(string $str): string
	{
		return strtr($str, array_flip($this->_namedToNumeric));
	}

	/**
	 * DECODE TO UTF8
	 * (used for SQL match)
	 *
	 *  /!\ does not encode non-breaking spaces, thin spaces etc...
	 *
	 * @param string $str
	 * @return mixed
	 */
	public function toUTF8(string $str): string
	{
		# HTMLENTITIES
		$str = str_replace(array_keys($this->_aHtmlEntities), $this->_aHtmlEntities, $str);

		# ISO
		return str_replace(array_keys($this->_aIsoCode), $this->_aIsoCode, $str);
	}

	/**
	 * AUTOMATIC HTML5 TO UTF8
	 *
	 * @param string $str
	 * @return string
	 */
	public function to_HTML5_UTF8(string $str): string
	{
		return (string) preg_replace_callback('`(&#?([0-9]{2,4}|[a-z]{1,10});)`i', function ($matches) {
			if(empty($matches[0])) {
				return '';
			}
			return html_entity_decode($matches[0], ENT_QUOTES | ENT_HTML5);
		}, $str);
	}

	/**
	 * Decode spaces
	 *
	 * @param string $str
	 * @return string
	 */
	public function decodeSpaces(string $str): string
	{
		return Space::fix($str);
	}

	/**
	 * Encode spaces
	 *
	 * @param string $str
	 * @return string
	 */
	public function encodeSpaces(string $str): string
	{
		return Space::fix($str, Space::HTML_ENTITY_NO_BREAK_SPACE);
	}

	/**
	 * UTF-8 UCFirst
	 *
	 * @param string $str
	 * @return string
	 */
	public function ucfirst(string $str): string
	{
		return mb_strtoupper( mb_substr( $str, 0, 1 )) . mb_substr( $str, 1 );
	}

	/**
	 * Capitalize title
	 *
	 * @param string $str
	 * @return string
	 */
	public function caseTitle(string $str): string
	{
		return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
	}

	/**
	 * Capitalize name
	 *
	 * @param string $str
	 * @return string
	 */
	public function capitalize(string $str): string
	{
		$str = mb_strtolower($str);
		$chars = mb_str_split($str);
		$alpha = array_merge(range('a', 'z'), array_keys(self::ALPHABET_MAP));

		$full = '';
		$ucfirst = false;
		foreach($chars as $char) {
			$allowed = in_array($char, $alpha, true);
			if(!$ucfirst && $allowed) {
				$char = mb_strtoupper($char);
				$ucfirst = true;
			}

			if(!$allowed) {
				$ucfirst = false;
			}

			$full .= $char;
		}
		return $full;
	}

	/**
	 * SANITIZE STRING
	 * for title, subtitle, or other one line strings
	 *
	 * @param string $str
	 * @return string
	 */
	public function sanitizeOneLineStrings(string $str): string
	{
		$str = preg_replace('`<\s*br\s*/?\s*>`i', ' ', $str);
		$str = preg_replace('/[\r\n\t]+/u', ' ', $str);
		$str = strip_tags($str);
		$str = Space::fix($str, Space::UTF8_REGULAR_SPACE);
		return trim($str);
	}

	/**
	 * Delete Accents
	 *
	 * @param string $str
	 * @return string
	 */
	public function removeAccent(string $str): string
	{
		# Remove combining accents (U+0300 to U+036F)
		$str = preg_replace('/[\x{0300}-\x{036F}]/u', '', $str);

		# Replace special chars
		return str_replace(array_keys(self::ALPHABET_MAP), self::ALPHABET_MAP, $str);
	}

	/**
	 * Cleans Characters (for example : write url)
	 *
	 * @param string $str
	 * @param string $glue [optional]
	 * @param bool $symbol [optional]
	 * @return string
	 */
	public function clean(string $str, string $glue = '-', bool $symbol = false): string
	{
		# Remove html entities and html tags
		$str = html_entity_decode($str, ENT_QUOTES|ENT_SUBSTITUTE, 'utf-8');
		$str = preg_replace('`(&#?([0-9]{2,4}|[a-z]{1,10});)`i', $glue, $str);
		$str = strip_tags($str);

		# Remove accent and to lower string
		if($symbol) {
			$str = Symbol::fix($str);
		}
		$str = $this->removeAccent($str);
		$str = strtolower($str);

		# Delete all special chars remaining
		$str = preg_replace('#[^0-9a-z]+#i', $glue, $str) ;

		# Delete duplicates / and start-end
		if($glue) {
			while(strpos($str, $glue.$glue) !== false) {
				$str = str_replace($glue.$glue, $glue, $str);
			}
		}
		return trim($str, " \n\r\t\v\0$glue") ;
	}

	/**
	 * FAT TRIM
	 *
	 * @param string $str
	 * @return string
	 */
	public function trim(string $str): string
	{
		return $this->clean($str, ' ');
	}

	/**
	 * Strip tags with their content (or keep content)
	 *
	 * @param string $str The html to process
	 * @param string $tags [optional] Tags list to allow or disallow (e.g. '<b><i>' or 'b,i' or 'b i')
	 * @param bool $disallow [optional] If true, $tags is a list of tags TO REMOVE; if false, $tags is a list of tags TO KEEP.
	 * @param bool $keep If true, keep the inner content of removed nodes; if false, remove node and its children.
	 * @return string Cleaned HTML/text
	 * @throws DOMException
	 */
	public function strip(string $str, string $tags = '', bool $disallow = false, bool $keep = false): string
	{
		if (!trim($str)) {
			return $str;
		}

		# Build canonical tag list (lowercase).
		$tagsList = [];
		$tagsTrim = trim($tags);
		if ($tagsTrim !== '') {
			# Support "<b><i>".
			if (preg_match_all('/<\s*([a-z0-9]+)\s*>/i', $tagsTrim, $m)) {
				$tagsList = $m[1];
			}
			# Support "b,i" or "b i".
			else {
				$parts = preg_split('/[,\s]+/', $tagsTrim);
				$tagsList = array_filter($parts, fn($p) => $p !== '');
			}
			$tagsList = array_map('strtolower', $tagsList);
		}

		# Silence libxml warnings
		$useInternal = libxml_use_internal_errors(true);

		$dom = new DOMDocument('1.0', 'UTF-8');

		# Wrap into a known container to preserve top-level text nodes and avoid losing text.
		$wrapperId = uniqid('slugify_wrapper_');
		$wrapped = '<div id="' . $wrapperId . '">' . $str . '</div>';

		# Load HTML fragment.
		# We prefix with an XML encoding hint so DOMDocument recognizes UTF-8 reliably,
		@$dom->loadHTML('<?xml encoding="utf-8"?>' . $wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

		# Find the wrapper node
		$wrapper = $dom->getElementById($wrapperId);
		if (!$wrapper) {
			# fallback: create a wrapper element manually if not found
			$wrapper = $dom->createElement('div');
			while ($dom->firstChild) {
				$wrapper->appendChild($dom->firstChild);
			}
			$dom->appendChild($wrapper);
		}

		# Collect descendant elements in an array (deepest first)
		$nodes = [];
		$xpath = new DOMXPath($dom);
		foreach ($xpath->query('.//*', $wrapper) as $n) {
			$nodes[] = $n;
		}

		# Iterate from deepest to root to avoid issues when removing nodes
		for ($i = count($nodes) - 1; $i >= 0; $i--) {
			$node = $nodes[$i];
			if (!$node instanceof DOMElement) {
				continue;
			}

			# Determine whether to remove this tag according to tagsList/disallow rules
			$tag = strtolower($node->nodeName);
			$isListed = in_array($tag, $tagsList, true);
			# No list provided:
			if (!$tagsList) {
				$shouldRemove = !$disallow;
			}
			else {
				$shouldRemove = $disallow ? $isListed : !$isListed;
			}
			if (!$shouldRemove) {
				continue;
			}

			# Nothing to do if orphan
			if (!$parent = $node->parentNode) {
				continue;
			}

			# Insert before the node; this moves the node from its current parent
			if ($keep) {
				$children = [];
				foreach ($node->childNodes as $c) {
					$children[] = $c;
				}
				foreach ($children as $child) {
					$parent->insertBefore($child, $node);
				}
			}

			# Remove node
			$parent->removeChild($node);
		}

		# Extract inner HTML of the wrapper (concatenate children)
		$result = '';
		foreach ($wrapper->childNodes as $child) {
			$result .= $dom->saveHTML($child);
		}
		# Restore libxml error handling state
		libxml_clear_errors();
		libxml_use_internal_errors($useInternal);

		return $result;
	}

	/**
	 * Detecting a valid name or first name international
	 *
	 * @param string $name
	 * @return bool
	 */
	public function pregName(string $name): bool
	{
		return (bool) preg_match('/^\p{L}+(?:[\'’‘´`\- ]\p{L}+)*$/u', $name);
	}

	/**
	 * Extract Text
	 *
	 * @param string $text
	 * @param int $length
	 * @param int $decode [optional]
	 * @param string $charset [optional]
	 * @return string
	 */
	public function substrText(string $text, int $length = 300, int $decode = ENT_HTML5, string $charset = 'UTF-8'): string
	{
		# Convert chars
		$text = html_entity_decode($text, $decode, $charset);
		$text = Space::fix($text, Space::UTF8_REGULAR_SPACE);
		$text = trim(strip_tags($text));
		if (!$text) {
			return '';
		}

		# Shorten than given length
		if(mb_strlen($text) < $length) {
			return $text;
		}

		# Extract to next space or exact length
		if(false !== $pos = mb_strpos($text, ' ', $length)) {
			$length = $pos;
		}
		return mb_substr($text, 0, $length);
	}

	/**
	 * Clean string for sql search optimisation
	 *
	 * @param string $str
	 * @param int $decode [optional]
	 * @param string $charset [optional]
	 * @return string
	 */
	public function searchSqlCleaner(string $str, int $decode = ENT_HTML5, string $charset = 'UTF-8'): string
	{
		# HTML decode and remove tags
		$str = html_entity_decode($str, $decode, $charset);
		$str = trim(strip_tags($str));

		# Some texts may use accent marks instead of proper apostrophes.
		# For consistency in SQL search normalization, these characters are converted to a simple apostrophe `'`.
		# This ensures that names like “D´Angelo” or “D`Angelo” are treated as “D'Angelo”.
		$str = Apostrophe::fix($str);

		# Delete all remains encoded and remove all accent chars
		$str = preg_replace('`(&#?([0-9]{2,4}|[a-z]{1,10});)`i', '', $str);
		$str = $this->removeAccent($str);

		# Retains only alphabet chars, number, tiret and simple quote
		mb_internal_encoding($charset);
		mb_regex_encoding($charset);
		$str = mb_eregi_replace('[^a-z0-9\' -]+', ' ', $str) ;

		# Delete tirets (OCR breakwords)
		$str = str_replace('-', '', $str);

		# Delete parasitics whitespaces
		return Space::fix($str, ' ');
	}

	/**
	 * Camel Case a string, remove all that is not a-z 0-9
	 *
	 * @param string $str
	 * @param bool $pascal [optional] Switch to PascalCase mode
	 * @return string
	 */
	public function camelCase(string $str, bool $pascal = false): string
	{
		$str = $this->clean($str, ' ');
		$str = ucwords($str, ' ');
		$str = str_replace(' ', '', $str);
		if(!$pascal) {
			$str = lcfirst($str);
		}
		return $str;
	}

	/**
	 * @alias self::camelCase
	 * @param string $str
	 * @return string
	 */
	public function pascalCase(string $str): string
	{
		return $this->camelCase($str, true);
	}
}
