<?php
namespace Coercive\Utility\Slugify;

/**
 * Slugify Apostrophe
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
class Apostrophe
{
	#
	# UTF8
	#
	const UTF8_REGULAR_APOSTROPHE = '\'';
	const UTF8_LEFT_SINGLE_QUOTATION_MARK = '‘';
	const UTF8_RIGHT_SINGLE_QUOTATION_MARK = '’';
	const UTF8_SINGLE_LOW9_QUOTATION_MARK = '‚';
	const UTF8_ACUTE_ACCENT = '´';
	const UTF8_GRAVE_ACCENT = '`';

	const UTF8_APOSTROPHES = [
		self::UTF8_LEFT_SINGLE_QUOTATION_MARK,
		self::UTF8_RIGHT_SINGLE_QUOTATION_MARK,
		self::UTF8_SINGLE_LOW9_QUOTATION_MARK,
	];

	#
	# HTML ENTITIES
	#
	const HTML_ENTITY_REGULAR_APOSTROPHE = '&apos;';
	const HTML_ENTITY_LEFT_SINGLE_QUOTATION_MARK = '&lsquo;';
	const HTML_ENTITY_LEFT_SINGLE_QUOTATION_MARK_ALT = '&OpenCurlyQuote;';
	const HTML_ENTITY_RIGHT_SINGLE_QUOTATION_MARK = '&rsquo;';
	const HTML_ENTITY_RIGHT_SINGLE_QUOTATION_MARK_ALT = '&CloseCurlyQuote;';
	const HTML_ENTITY_SINGLE_LOW9_QUOTATION_MARK = '&sbquo;';
	const HTML_ENTITY_ACUTE_ACCENT = '&acute;';
	const HTML_ENTITY_ACUTE_ACCENT_ALT = '&DiacriticalAcute;';
	const HTML_ENTITY_GRAVE_ACCENT = '&grave;';
	const HTML_ENTITY_GRAVE_ACCENT_ALT = '&DiacriticalGrave;';

	const HTML_ENTITY_APOSTROPHES = [
		self::HTML_ENTITY_REGULAR_APOSTROPHE,
		self::HTML_ENTITY_LEFT_SINGLE_QUOTATION_MARK,
		self::HTML_ENTITY_LEFT_SINGLE_QUOTATION_MARK_ALT,
		self::HTML_ENTITY_RIGHT_SINGLE_QUOTATION_MARK,
		self::HTML_ENTITY_RIGHT_SINGLE_QUOTATION_MARK_ALT,
		self::HTML_ENTITY_SINGLE_LOW9_QUOTATION_MARK,
	];

	#
	# DIGITAL ENTITIES
	#
	const DIGITAL_ENTITY_REGULAR_APOSTROPHE = '&#39;';
	const DIGITAL_ENTITY_LEFT_SINGLE_QUOTATION_MARK = '&#8216;';
	const DIGITAL_ENTITY_RIGHT_SINGLE_QUOTATION_MARK = '&#8217;';
	const DIGITAL_ENTITY_SINGLE_LOW9_QUOTATION_MARK = '&#8218;';
	const DIGITAL_ENTITY_ACUTE_ACCENT = '&#180;';
	const DIGITAL_ENTITY_GRAVE_ACCENT = '&#96;';

	const DIGITAL_ENTITY_APOSTROPHES = [
		self::DIGITAL_ENTITY_REGULAR_APOSTROPHE,
		self::DIGITAL_ENTITY_LEFT_SINGLE_QUOTATION_MARK,
		self::DIGITAL_ENTITY_RIGHT_SINGLE_QUOTATION_MARK,
		self::DIGITAL_ENTITY_SINGLE_LOW9_QUOTATION_MARK,
	];

	#
	# HEX DIGITAL ENTITIES
	#
	const HEX_ENTITY_REGULAR_APOSTROPHE = '&#x27;';
	const HEX_ENTITY_LEFT_SINGLE_QUOTATION_MARK = '&#x2018;';
	const HEX_ENTITY_RIGHT_SINGLE_QUOTATION_MARK = '&#x2019;';
	const HEX_ENTITY_SINGLE_LOW9_QUOTATION_MARK = '&#x201A;';
	const HEX_ENTITY_ACUTE_ACCENT = '&#xB4;';
	const HEX_ENTITY_GRAVE_ACCENT_ALT = '&#x60;';

	const HEX_ENTITY_APOSTROPHES = [
		self::HEX_ENTITY_REGULAR_APOSTROPHE,
		self::HEX_ENTITY_LEFT_SINGLE_QUOTATION_MARK,
		self::HEX_ENTITY_RIGHT_SINGLE_QUOTATION_MARK,
		self::HEX_ENTITY_SINGLE_LOW9_QUOTATION_MARK,
	];

	static public function fix(string $str, string $char = self::UTF8_REGULAR_APOSTROPHE, bool $accent = true): string
	{
		$str = str_replace(self::UTF8_APOSTROPHES, $char, $str);
		$str = str_replace(self::HTML_ENTITY_APOSTROPHES, $char, $str);
		$str = str_replace(self::DIGITAL_ENTITY_APOSTROPHES, $char, $str);
		$str = str_replace(self::HEX_ENTITY_APOSTROPHES, $char, $str);
		if($accent) {
			$str = str_replace([
				self::UTF8_ACUTE_ACCENT,
				self::UTF8_GRAVE_ACCENT,
				self::HTML_ENTITY_ACUTE_ACCENT,
				self::HTML_ENTITY_ACUTE_ACCENT_ALT,
				self::HTML_ENTITY_GRAVE_ACCENT,
				self::HTML_ENTITY_GRAVE_ACCENT_ALT,
				self::DIGITAL_ENTITY_ACUTE_ACCENT,
				self::DIGITAL_ENTITY_GRAVE_ACCENT,
				self::HEX_ENTITY_ACUTE_ACCENT,
				self::HEX_ENTITY_GRAVE_ACCENT_ALT,
			], $char, $str);
		}
		if($char) {
			$str = preg_replace('/' . $char . '{2,}/u', $char, $str);
		}
		return $str;
	}
}