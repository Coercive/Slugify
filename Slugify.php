<?php
namespace Coercive\Utility\Slugify;

/**
 * Slugify
 * PHP Version 	5
 *
 * @version		1
 * @package 	Coercive\Utility\Slugify
 * @link		@link https://github.com/Coercive/Slugify
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2016 - 2017 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
class Slugify {

	/** @var array ACCENT / NO ACCENT*/
	private $a = ['À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'];
	private $b = ['A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'];

	/** @var array ENTITY / DECODE */
	private $_aHtmlEntities = [
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
	private $_aSpaces = [
		'&nbsp;' => ' ', # insecable
		'&#160;' => ' ', # insecable
		'&ensp;' => ' ', # 2 spaces
		'&emsp;' => ' ', # 4 spaces
		'&thinsp;' => ' ', # fine space
		'&#8239;' => ' ', # insecable fine space
	];

	/**
	 * DECODE TO UTF8
	 * (used for SQL match)
	 *
	 *  /!\ does not encode non-breaking spaces, thin spaces etc...
	 *
	 * @param string $sString
	 * @return mixed
	 */
	public function toUTF8($sString) {

		# HTMLENTITIES
		$sString = str_replace(array_keys($this->_aHtmlEntities), $this->_aHtmlEntities, $sString);

		# ISO
		$sString = str_replace(array_keys($this->_aIsoCode), $this->_aIsoCode, $sString);

		return $sString;
	}

	/**
	 * AUTOMATIC HTML5 TO UTF8
	 *
	 * @param $sString
	 * @return mixed
	 */
	public function to_HTML5_UTF8($sString) {
		return preg_replace_callback('`(&#?([0-9]{2,4}|[a-z]{1,10});)`i', [$this, '_decode_HTML5_UTF8'], $sString);
	}
	private function _decode_HTML5_UTF8($aPregReplaceArray) {
		if(empty($aPregReplaceArray[0])) { return ''; }
		return html_entity_decode($aPregReplaceArray[0], ENT_QUOTES | ENT_HTML5);
	}

	/**
	 * DECODE SPACES
	 *
	 * @param string $sString
	 * @return string
	 */
	public function decodeSpaces($sString) {
		return str_replace(array_keys($this->_aSpaces), $this->_aSpaces, $sString);
	}
	
	/**
	 * REDECODE SPACES
	 *
	 * @param string $sString
	 * @return string
	 */
	public function encodeSpaces($sString) {
		$aSpaceEntities = array_keys($this->_aSpaces);
		foreach ($aSpaceEntities as $sSpace) {
			$sString = str_replace(html_entity_decode($sSpace, null, 'utf-8'), $sSpace, $sString);
		}
		return $sString;
	}

	/**
	 * SANITIZE STRING
	 * for title, subtitle, or other one line strings
	 *
	 * @param string $sString
	 * @return string
	 */
	public function sanitizeOneLineStrings($sString) {
		$sString = $this->decodeSpaces($sString);
		$sString = preg_replace('`<br>|<br >|<br/>|<br />|</br>`i', ' ', $sString);
		$sString = strip_tags($sString);
		while (strpos($sString, '  ') !== false) { $sString = str_replace('  ', ' ', $sString); }
		return $sString;
	}

	/**
	 * Delete Accents
	 *
	 * @param string $sString
	 * @return string
	 */
	public function removeAccent($sString) {
		return str_replace($this->a, $this->b, $sString);
	}

	/**
	 * Cleans Characters (for example : write url)
	 *
	 * @param string $sString
	 * @return string
	 */
	public function clean($sString) {
		$sString = $this->removeAccent($sString);
		$sString = strtolower($sString);
		$sString = strip_tags($sString);
		$sString = str_replace('&nbsp;', ' ', $sString);
		$sString = str_replace('&thinsp;', ' ', $sString);
		$sString = str_replace('&#8239;', ' ', $sString);
		$sString = preg_replace( '#[^0-9a-z]+#i', '-', $sString ) ;

		while( strpos( $sString, '--' ) !== false ) { $sString = str_replace( '--', '-', $sString ); }

		$sString = trim( $sString, '-' ) ;
		$sString = strtolower( $sString ) ;
		return $sString ;
	}

	/**
	 * FAT TRIM
	 *
	 * @param string $sString
	 * @return mixed|string
	 */
	public function trim($sString) {
		$sString = $this->removeAccent($sString);
		$sString = strtolower($sString);
		$sString = strip_tags($sString);
		$sString = str_replace('&nbsp;', '', $sString);
		$sString = str_replace('&thinsp;', '', $sString);
		$sString = str_replace('&#8239;', '', $sString);
		$sString = preg_replace('#[^0-9a-z]+#i', '', $sString);
		return $sString ;
	}

	/**
	 * Detecting a valid name or first name internationnal
	 *
	 * @param string $sName
	 * @return bool
	 */
	public function pregName($sName) {
		$sAccep = '';
		foreach($this->a as $sAcceptLetter) { $sAccep .= $sAcceptLetter; }
		return preg_match('#^[a-zA-Z'.$sAccep.'\'\- ]+$#', $sName);
	}

	/**
	 * Extract Text
	 *
	 * @param string $sText
	 * @param int $iNb
	 * @return string
	 */
	public function substrText($sText, $iNb = 300) {

		# Security
		$sText = $this->decodeSpaces($sText);
		$sText = strip_tags($sText);
		if (!$sText) { return ''; }

		# Extract
		if(strlen($sText) < $iNb) { $iNb = strlen($sText); }
		$iNb = strpos($sText, ' ', $iNb);
		if($iNb === false) { $iNb = strlen($sText); }
		$sText = substr($sText, 0, $iNb);

		return $sText;
	}
}
