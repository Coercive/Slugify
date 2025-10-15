<?php
namespace Coercive\Utility\Slugify;

/**
 * Slugify Symbol
 *
 * @package Coercive\Utility\Slugify
 * @link https://github.com/Coercive/Slugify
 *
 * @author Anthony Moral <contact@coercive.fr>
 * @copyright © 2025 Anthony Moral
 * @license MIT
 */
class Symbol
{
	const SYMBOL_MAP = [
		# Brands
		'©' => 'c',
		'®' => 'r',
		'™' => 'tm',

		# Currencies
		'€' => 'euro',
		'$' => 'dollar',
		'£' => 'livre',
		'¥' => 'yen',
		'₩' => 'won',
		'₽' => 'ruble',
		'₹' => 'rs',

		# Typographic symbols
		'°' => 'deg',
		'№' => 'no',
		'§' => 'section',
		'¶' => 'para',

		# Mathematical and logical symbols
		'+' => 'plus',
		'±' => 'plus-minus',
		'=' => 'equals',
		'×' => 'x',
		'÷' => 'div',
		'≈' => 'approx',
		'<' => 'lt',
		'>' => 'gt',

		# Misc symboles
		'&' => 'and',
		'@' => 'at',
		'#' => 'hash',
		'%' => 'percent',
		'^' => 'caret',
		'*' => 'star',
		'~' => 'tilde',

		# Arrows
		'→' => 'to',
		'←' => 'from',
		'↔' => 'to',
		'↑' => 'up',
		'↓' => 'down',

		# Decorative Misc symboles
		'♥' => 'love',
		'♡' => 'love',
		'★' => 'star',
		'☆' => 'star',
		'☀' => 'sun',
		'☁' => 'cloud',
		'☂' => 'umbrella',
		'☃' => 'snowman',
		'☎' => 'phone',
		'✉' => 'mail',

		# Latin letter-like
		'ℓ' => 'l',
		'℮' => 'e',
		'Ω' => 'ohm',
		'Å' => 'a',
		'ℳ' => 'm',
		'ℜ' => 'r',
		'ℵ' => 'aleph',

		# Common fractions
		'½' => '1-2',
		'⅓' => '1-3',
		'⅔' => '2-3',
		'¼' => '1-4',
		'¾' => '3-4',
	];

	const ALT_SYMBOL_FR = [

		# Mathematical and logical symbols
		'±' => 'plus ou moins',
		'=' => 'égal',
		'<' => 'inférieur',
		'>' => 'supérieur',

		# Misc symboles
		'&' => 'et',
		'@' => 'arobase',
		'#' => 'dièse',
		'%' => 'pourcent',
		'^' => 'circonflexe',
		'*' => 'étoile',

		# Arrows
		'→' => 'vers',
		'←' => 'depuis',
		'↔' => 'vers',
		'↑' => 'haut',
		'↓' => 'bas',

		# Decorative Misc symboles
		'♥' => 'cœur',
		'♡' => 'cœur',
		'★' => 'étoile',
		'☆' => 'étoile',
		'☀' => 'soleil',
		'☁' => 'nuage',
		'☂' => 'parapluie',
		'☃' => 'bonhomme de neige',
		'☎' => 'téléphone',
		'✉' => 'courriel',
	];

	const ALT_SYMBOL_IT = [

		# Currencies
		'$' => 'dollaro',
		'£' => 'lira',

		# Typographic symbols
		'°' => 'gradi',
		'§' => 'sezione',

		# Mathematical and logical symbols
		'+' => 'più',
		'±' => 'più o meno',
		'=' => 'pari',
		'<' => 'inferiore',
		'>' => 'superiore',

		# Misc symboles
		'&' => 'e',
		'@' => 'A',
		'#' => 'affilato',
		'%' => 'percento',
		'^' => 'circonflesso',
		'*' => 'stella',

		# Arrows
		'→' => 'a',
		'←' => 'da',
		'↔' => 'verso',
		'↑' => 'alto',
		'↓' => 'giù',

		# Decorative Misc symboles
		'♥' => 'amore',
		'♡' => 'amore',
		'★' => 'stella',
		'☆' => 'stella',
		'☀' => 'sole',
		'☁' => 'nuvola',
		'☂' => 'ombrello',
		'☃' => 'pupazzo di neve',
		'☎' => 'telefono',
		'✉' => 'e-mail',
	];

	const ALT_SYMBOL_ES = [

		# Currencies
		'$' => 'dolar',
		'£' => 'libra',

		# Typographic symbols
		'°' => 'grados',
		'§' => 'sección',

		# Mathematical and logical symbols
		'+' => 'más',
		'±' => 'más o menos',
		'=' => 'igual',
		'<' => 'menos que',
		'>' => 'más que',

		# Misc symboles
		'&' => 'y',
		'@' => 'en',
		'#' => 'afilado',
		'%' => 'porciento',
		'^' => 'circunflejo',
		'*' => 'estrella',

		# Arrows
		'→' => 'a',
		'←' => 'desde',
		'↔' => 'hacia',
		'↓' => 'abajo',

		# Decorative Misc symboles
		'♥' => 'amor',
		'♡' => 'amor',
		'★' => 'estrella',
		'☆' => 'estrella',
		'☀' => 'sol',
		'☁' => 'nube',
		'☂' => 'paraguas',
		'☃' => 'muñeco de nieve',
		'☎' => 'teléfono',
		'✉' => 'correo electrónico',
	];

	const ALT_SYMBOL_DE = [

		# Currencies
		'£' => 'pfund',

		# Typographic symbols
		'§' => 'Abschnitt',
		'¶' => 'Absatz',

		# Mathematical and logical symbols
		'±' => 'plusminus',
		'=' => 'gleich',
		'<' => 'weniger als',
		'>' => 'größer als',

		# Misc symboles
		'&' => 'und',
		'@' => 'bei',
		'#' => 'scharf',
		'%' => 'prozent',
		'^' => 'Zirkumflex',
		'*' => 'stern',

		# Arrows
		'→' => 'zu',
		'←' => 'von',
		'↔' => 'in Richtung',
		'↑' => 'hoch',
		'↓' => 'runter',

		# Decorative Misc symboles
		'♥' => 'liebe',
		'♡' => 'liebe',
		'★' => 'stern',
		'☆' => 'stern',
		'☀' => 'Sonne',
		'☁' => 'Wolke',
		'☂' => 'Regenschirm',
		'☃' => 'Schneemann',
		'☎' => 'Telefon',
		'✉' => 'E-Mail',
	];

	/**
	 * @var array[] MAP by language
	 */
	static private $languages = [
		'en' => self::SYMBOL_MAP,
	];

	static private string $language = 'en';

	static public function setLanguage(string $language): void
	{
		self::$language = $language;
	}

	static public function init(array $overrides = []): void
	{
		self::$languages = [
			'en' => self::SYMBOL_MAP,
			'fr' => self::ALT_SYMBOL_FR,
			'it' => self::ALT_SYMBOL_IT,
			'es' => self::ALT_SYMBOL_ES,
			'de' => self::ALT_SYMBOL_DE,
		];
		if($overrides) {
			self::$languages = array_merge(self::$languages, $overrides);
		}
	}

	static public function fix(string $str, string $lang = ''): string
	{
		$map = self::$languages[$lang ?: self::$language] ?? self::$languages['en'];
		return strtr($str, $map);
	}
}