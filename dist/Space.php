<?php
namespace Coercive\Utility\Slugify;

/**
 * Slugify Space
 *
 * @package Coercive\Utility\Slugify
 * @link https://github.com/Coercive/Slugify
 *
 * @author Anthony Moral <contact@coercive.fr>
 * @copyright © 2025 Anthony Moral
 * @license MIT
 *
 * Best website ever for special chars
 * @link https://www.compart.com
 */
class Space
{
	#
	# UTF8
	#
	const UTF8_REGULAR_SPACE = ' ';
	const UTF8_NO_BREAK_SPACE = "\u{00A0}"; # NBSP
	const UTF8_EN_QUAD = "\u{2000}"; # 1/2 cadratin
	const UTF8_EM_QUAD = "\u{2001}"; # 1 cadratin
	const UTF8_EN_SPACE = "\u{2002}"; # 1/2 cadratin
	const UTF8_EM_SPACE = "\u{2003}"; # 1 cadratin
	const UTF8_THREE_PER_EM_SPACE = "\u{2004}"; # 1/3 cadratin
	const UTF8_FOUR_PER_EM_SPACE = "\u{2005}"; # 1/4 cadratin
	const UTF8_SIX_PER_EM_SPACE = "\u{2006}"; # 1/6 cadratin
	const UTF8_FIGURE_SPACE = "\u{2007}"; # width of a digit / tab space
	const UTF8_PUNCTUATION_SPACE = "\u{2008}";
	const UTF8_THIN_SPACE = "\u{2009}"; # ≈1/5 cadratin
	const UTF8_HAIR_SPACE = "\u{200A}"; # Very thin space
	const UTF8_ZWSP_SPACE = "\u{200B}"; # Zero Width Space
	const UTF8_ZWNJ = "\u{200C}"; # Zero Width Non-Joiner
	const UTF8_ZWJ = "\u{200D}"; # Zero Width Joiner
	const UTF8_LINE_SEPARATOR = "\u{2028}";
	const UTF8_PARAGRAPH_SEPARATOR = "\u{2029}";
	const UTF8_NARROW_NO_BREAK_SPACE = "\u{202F}"; # smaller than nbsp
	const UTF8_IDEOGRAPHIC_SPACE = "\u{3000}"; # full width (equivalent to one Chinese character)

	const UTF8_SPACES = [
		self::UTF8_NO_BREAK_SPACE,
		self::UTF8_EN_SPACE,
		self::UTF8_EM_SPACE,
		self::UTF8_THREE_PER_EM_SPACE,
		self::UTF8_FOUR_PER_EM_SPACE,
		self::UTF8_SIX_PER_EM_SPACE,
		self::UTF8_FIGURE_SPACE,
		self::UTF8_PUNCTUATION_SPACE,
		self::UTF8_THIN_SPACE,
		self::UTF8_HAIR_SPACE,
		self::UTF8_ZWSP_SPACE,
		self::UTF8_NARROW_NO_BREAK_SPACE,
		self::UTF8_IDEOGRAPHIC_SPACE,
	];

	#
	# HTML ENTITIES
	#
	const HTML_ENTITY_NO_BREAK_SPACE = '&nbsp;';
	const HTML_ENTITY_NO_BREAK_SPACE_ALT = '&NonBreakingSpace;';
	const HTML_ENTITY_EN_SPACE = '&ensp;';
	const HTML_ENTITY_EM_SPACE = '&emsp;';
	const HTML_ENTITY_THREE_PER_EM_SPACE = '&emsp13;';
	const HTML_ENTITY_FOUR_PER_EM_SPACE = '&emsp14;';
	const HTML_ENTITY_FIGURE_SPACE = '&numsp;';
	const HTML_ENTITY_PUNCTUATION_SPACE = '&puncsp;';
	const HTML_ENTITY_THIN_SPACE = '&thinsp;';
	const HTML_ENTITY_THIN_SPACE_ALT = '&ThinSpace;';
	const HTML_ENTITY_HAIR_SPACE = '&VeryThinSpace;';
	const HTML_ENTITY_ZWSP_SPACE = '&NegativeVeryThinSpace;';
	const HTML_ENTITY_ZWNJ = '&zwnj;';
	const HTML_ENTITY_ZWJ = '&zwj;';

	const HTML_ENTITY_SPACES = [
		self::HTML_ENTITY_NO_BREAK_SPACE,
		self::HTML_ENTITY_NO_BREAK_SPACE_ALT,
		self::HTML_ENTITY_EN_SPACE,
		self::HTML_ENTITY_EM_SPACE,
		self::HTML_ENTITY_THREE_PER_EM_SPACE,
		self::HTML_ENTITY_FOUR_PER_EM_SPACE,
		self::HTML_ENTITY_FIGURE_SPACE,
		self::HTML_ENTITY_PUNCTUATION_SPACE,
		self::HTML_ENTITY_THIN_SPACE,
		self::HTML_ENTITY_THIN_SPACE_ALT,
		self::HTML_ENTITY_HAIR_SPACE,
		self::HTML_ENTITY_ZWSP_SPACE,
	];

	#
	# DIGITAL ENTITIES
	#
	const DIGITAL_ENTITY_NO_BREAK_SPACE = '&#160;';
	const DIGITAL_ENTITY_EN_QUAD = '&#8192;';
	const DIGITAL_ENTITY_EM_QUAD = '&#8193;';
	const DIGITAL_ENTITY_EN_SPACE = '&#8194;';
	const DIGITAL_ENTITY_EM_SPACE = '&#8195;';
	const DIGITAL_ENTITY_THREE_PER_EM_SPACE = '&#8196;';
	const DIGITAL_ENTITY_FOUR_PER_EM_SPACE = '&#8197;';
	const DIGITAL_ENTITY_SIX_PER_EM_SPACE = '&#8198;';
	const DIGITAL_ENTITY_FIGURE_SPACE = '&#8199;';
	const DIGITAL_ENTITY_PUNCTUATION_SPACE = '&#8200;';
	const DIGITAL_ENTITY_THIN_SPACE = '&#8201;';
	const DIGITAL_ENTITY_HAIR_SPACE = '&#8202;';
	const DIGITAL_ENTITY_ZWSP_SPACE = '&#8203;';
	const DIGITAL_ENTITY_ZWNJ = '&#8204;';
	const DIGITAL_ENTITY_ZWJ = '&#8205;';
	const DIGITAL_ENTITY_LINE_SEPARATOR = '&#8232;';
	const DIGITAL_ENTITY_PARAGRAPH_SEPARATOR = '&#8233;';
	const DIGITAL_ENTITY_NARROW_NO_BREAK_SPACE = '&#8239;';
	const DIGITAL_ENTITY_IDEOGRAPHIC_SPACE = '&#12288;';

	const DIGITAL_ENTITY_SPACES = [
		self::DIGITAL_ENTITY_NO_BREAK_SPACE,
		self::DIGITAL_ENTITY_EN_SPACE,
		self::DIGITAL_ENTITY_EM_SPACE,
		self::DIGITAL_ENTITY_THREE_PER_EM_SPACE,
		self::DIGITAL_ENTITY_FOUR_PER_EM_SPACE,
		self::DIGITAL_ENTITY_SIX_PER_EM_SPACE,
		self::DIGITAL_ENTITY_FIGURE_SPACE,
		self::DIGITAL_ENTITY_PUNCTUATION_SPACE,
		self::DIGITAL_ENTITY_THIN_SPACE,
		self::DIGITAL_ENTITY_HAIR_SPACE,
		self::DIGITAL_ENTITY_ZWSP_SPACE,
		self::DIGITAL_ENTITY_NARROW_NO_BREAK_SPACE,
		self::DIGITAL_ENTITY_IDEOGRAPHIC_SPACE,
	];

	#
	# HEX DIGITAL ENTITIES
	#
	const HEX_ENTITY_NO_BREAK_SPACE = '&#xA0;';
	const HEX_ENTITY_EN_QUAD = '&#x2000;';
	const HEX_ENTITY_EM_QUAD = '&#x2001;';
	const HEX_ENTITY_EN_SPACE = '&#x2002;';
	const HEX_ENTITY_EM_SPACE = '&#x2003;';
	const HEX_ENTITY_THREE_PER_EM_SPACE = '&#x2004;';
	const HEX_ENTITY_FOUR_PER_EM_SPACE = '&#x2005;';
	const HEX_ENTITY_SIX_PER_EM_SPACE = '&#x2006;';
	const HEX_ENTITY_FIGURE_SPACE = '&#x2007;';
	const HEX_ENTITY_PUNCTUATION_SPACE = '&#x2008;';
	const HEX_ENTITY_THIN_SPACE = '&#x2009;';
	const HEX_ENTITY_HAIR_SPACE = '&#x200A;';
	const HEX_ENTITY_ZWSP_SPACE = '&#x200B;';
	const HEX_ENTITY_ZWNJ = '&#x200C;';
	const HEX_ENTITY_ZWJ = '&#x200D;';
	const HEX_ENTITY_LINE_SEPARATOR = '&#x2028;';
	const HEX_ENTITY_PARAGRAPH_SEPARATOR = '&#x2029;';
	const HEX_ENTITY_NARROW_NO_BREAK_SPACE = '&#x202F;';
	const HEX_ENTITY_IDEOGRAPHIC_SPACE = '&#x3000;';

	const HEX_ENTITY_SPACES = [
		self::HEX_ENTITY_NO_BREAK_SPACE,
		self::HEX_ENTITY_EN_SPACE,
		self::HEX_ENTITY_EM_SPACE,
		self::HEX_ENTITY_THREE_PER_EM_SPACE,
		self::HEX_ENTITY_FOUR_PER_EM_SPACE,
		self::HEX_ENTITY_SIX_PER_EM_SPACE,
		self::HEX_ENTITY_FIGURE_SPACE,
		self::HEX_ENTITY_PUNCTUATION_SPACE,
		self::HEX_ENTITY_THIN_SPACE,
		self::HEX_ENTITY_HAIR_SPACE,
		self::HEX_ENTITY_ZWSP_SPACE,
		self::HEX_ENTITY_NARROW_NO_BREAK_SPACE,
		self::HEX_ENTITY_IDEOGRAPHIC_SPACE,
	];

	static public function fix(string $str, string $char = self::UTF8_NO_BREAK_SPACE): string
	{
		$str = str_replace(self::UTF8_SPACES, $char, $str);
		$str = str_replace(self::HTML_ENTITY_SPACES, $char, $str);
		$str = str_replace(self::DIGITAL_ENTITY_SPACES, $char, $str);
		$str = str_replace(self::HEX_ENTITY_SPACES, $char, $str);
		$str = preg_replace('/ {2,}/u', ' ', $str);
		return trim($str);
	}
}