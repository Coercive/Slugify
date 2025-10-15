<?php declare(strict_types=1);

use Coercive\Utility\Slugify\Slugify;
use Coercive\Utility\Slugify\Symbol;
use PHPUnit\Framework\TestCase;

final class SlugifyTest extends TestCase
{
	protected Slugify $slugify;

	protected function setUp(): void
	{
		$this->slugify = new Slugify;
	}

	public function testConvertToNumericEntities(): void
	{
		# Vérifie la conversion simple d'entités HTML standards
		$this->assertSame('&#160;', $this->slugify->convertToNumericEntities('&nbsp;'));
		$this->assertSame('&#169;', $this->slugify->convertToNumericEntities('&copy;'));
		$this->assertSame('&#174;', $this->slugify->convertToNumericEntities('&reg;'));
		$this->assertSame('&#38;', $this->slugify->convertToNumericEntities('&amp;'));

		# Vérifie la conversion multiple sur une même chaîne
		$input = 'Copyright&nbsp;2025&nbsp;&copy;&nbsp;Anthony';
		$expected = 'Copyright&#160;2025&#160;&#169;&#160;Anthony';
		$this->assertSame($expected, $this->slugify->convertToNumericEntities($input));

		# Vérifie qu’une entité déjà numérique n’est pas modifiée
		$this->assertSame('&#160;', $this->slugify->convertToNumericEntities('&#160;'));
		$this->assertSame('&#xA0;', $this->slugify->convertToNumericEntities('&#xA0;'));

		# Vérifie que les entités inconnues ne sont pas modifiées
		$input = 'Hello &unknown; world';
		$this->assertSame($input, $this->slugify->convertToNumericEntities($input));

		# Vérifie que les entités échappées (comme &amp;nbsp;) ne sont pas converties
		$this->assertSame('&amp;nbsp;', $this->slugify->convertToNumericEntities('&amp;nbsp;'));
		$this->assertSame('&amp;copy;', $this->slugify->convertToNumericEntities('&amp;copy;'));

		# Vérifie que le texte sans entité reste inchangé
		$input = 'Ceci est un texte normal sans entités';
		$this->assertSame($input, $this->slugify->convertToNumericEntities($input));

		# Vérifie que les entités mixtes (HTML + texte) sont correctement traitées
		$input = 'Prix&nbsp;:&nbsp;10&nbsp;&euro;';
		$expected = 'Prix&#160;:&#160;10&#160;&#8364;';
		$this->assertSame($expected, $this->slugify->convertToNumericEntities($input));

		# Vérifie la robustesse sur des entités mal formées
		$input = 'Texte avec &incomplete et &&double;&nbsp;';
		$expected = 'Texte avec &incomplete et &&double;&#160;';
		$this->assertSame($expected, $this->slugify->convertToNumericEntities($input));

		# Vérifie la prise en charge d’entités majuscules
		$input = '&NBSP;&COPY;';
		$expected = '&#160;&#169;';
		$this->assertSame($expected, $this->slugify->convertToNumericEntities($input));

		# Vérifie que la conversion conserve les caractères non ASCII
		$input = 'Café&nbsp;☕&nbsp;😊';
		$expected = 'Café&#160;☕&#160;😊';
		$this->assertSame($expected, $this->slugify->convertToNumericEntities($input));

		# Cas échappé (dé-échappage activé)
		$this->assertSame('&#160;', $this->slugify->convertToNumericEntities('&amp;nbsp;', true));
		$this->assertSame('&#169;', $this->slugify->convertToNumericEntities('&amp;copy;', true));

		# Cas numérique déjà présent
		$this->assertSame('&#160;', $this->slugify->convertToNumericEntities('&#160;'));
		$this->assertSame('&#xA0;', $this->slugify->convertToNumericEntities('&#xA0;')); // hex → inchangé

		# Cas inconnu
		$this->assertSame('&unknown;', $this->slugify->convertToNumericEntities('&unknown;'));

		# Cas mixte complexe
		$input = 'Price&nbsp;&amp;euro;&lt;5&#62;&amp;unknown;';
		$expectedNoDeescape = 'Price&#160;&#38;euro;&#60;5&#62;&#38;unknown;';
		$expectedDeescape   = 'Price&#160;&#8364;&#60;5&#62;&unknown;';
		$this->assertSame($expectedNoDeescape, $this->slugify->convertToNumericEntities($input));
		$this->assertSame($expectedDeescape, $this->slugify->convertToNumericEntities($input, true));

		# Cas vide / neutre
		$this->assertSame('', $this->slugify->convertToNumericEntities(''));
		$this->assertSame('plain text', $this->slugify->convertToNumericEntities('plain text'));

		# Entrée combinant tous les cas problématiques
		$input = 'Début du test : &NBSP; &COPY; 10&lt;20&gt; ; Prix : 50&amp;euro; - Reste : &amp;nbsp; | &#37; ; Fin &amp;unknown;';
		$expected = 'Début du test : &#160; &#169; 10&#60;20&#62; ; Prix : 50&#38;euro; - Reste : &amp;nbsp; | &#37; ; Fin &#38;unknown;';
		$this->assertSame($expected, $this->slugify->convertToNumericEntities($input, false));
	}

	public function testReplaceHtmlEntitiesToUnicode(): void
	{
		# Entités HTML de Base (ASCII)
		$this->assertSame('A &#38; B', $this->slugify->replaceHtmlEntitiesToUnicode('A &amp; B'));
		$this->assertSame('2 &#60; 5', $this->slugify->replaceHtmlEntitiesToUnicode('2 &lt; 5'));
		$this->assertSame('5 &#62; 2', $this->slugify->replaceHtmlEntitiesToUnicode('5 &gt; 2'));
		$this->assertSame('"Text &#34;quoted&#34;"', $this->slugify->replaceHtmlEntitiesToUnicode('"Text &quot;quoted&quot;"'));

		# Entités HTML courantes (Non-ASCII)
		$this->assertSame('Price&#160;Final', $this->slugify->replaceHtmlEntitiesToUnicode('Price&nbsp;Final'));
		$this->assertSame('&#169; 2025', $this->slugify->replaceHtmlEntitiesToUnicode('&copy; 2025'));
		$this->assertSame('Cost &#8364;.', $this->slugify->replaceHtmlEntitiesToUnicode('Cost &euro;.'));
		$this->assertSame('Se&#241;or', $this->slugify->replaceHtmlEntitiesToUnicode('Se&ntilde;or'));

		# Gestion de la Casse (Doit convertir même en majuscule)
		$this->assertSame('Title &#160;', $this->slugify->replaceHtmlEntitiesToUnicode('Title &NBSP;'));
		$this->assertSame('&#169;', $this->slugify->replaceHtmlEntitiesToUnicode('&CoPy;'));

		# Entités Numériques Existantes (Doivent rester intactes)
		$this->assertSame('Value &#160;.', $this->slugify->replaceHtmlEntitiesToUnicode('Value &#160;.'));
		$this->assertSame('Value &#x20AC;.', $this->slugify->replaceHtmlEntitiesToUnicode('Value &#x20AC;.'));

		# Cas d'Entités Échappées et Inconnues
		$this->assertSame('Test &unknown; value', $this->slugify->replaceHtmlEntitiesToUnicode('Test &unknown; value'));
		$this->assertSame('Value &#99', $this->slugify->replaceHtmlEntitiesToUnicode('Value &#99'));
	}

	public function testReplaceUnicodeToHtmlEntities(): void
	{
		# Entités HTML de Base (ASCII)
		$this->assertSame('A &amp; B', $this->slugify->replaceUnicodeToHtmlEntities('A &#38; B'));
		$this->assertSame('2 &lt; 5', $this->slugify->replaceUnicodeToHtmlEntities('2 &#60; 5'));
		$this->assertSame('5 &gt; 2', $this->slugify->replaceUnicodeToHtmlEntities('5 &#62; 2'));
		$this->assertSame('"Text &quot;quoted&quot;"', $this->slugify->replaceUnicodeToHtmlEntities('"Text &#34;quoted&#34;"'));
		$this->assertSame('Title &nbsp;', $this->slugify->replaceUnicodeToHtmlEntities('Title &#160;'));
		$this->assertSame('&copy;', $this->slugify->replaceUnicodeToHtmlEntities('&#169;'));

		# Entités HTML courantes (Non-ASCII)
		$this->assertSame('Price&nbsp;Final', $this->slugify->replaceUnicodeToHtmlEntities('Price&#160;Final'));
		$this->assertSame('&copy; 2025', $this->slugify->replaceUnicodeToHtmlEntities('&#169; 2025'));
		$this->assertSame('Cost &euro;.', $this->slugify->replaceUnicodeToHtmlEntities('Cost &#8364;.'));
		$this->assertSame('Se&ntilde;or', $this->slugify->replaceUnicodeToHtmlEntities('Se&#241;or'));

		# Pas de correspondance HTML
		$this->assertSame('Value &#x20AC;.', $this->slugify->replaceUnicodeToHtmlEntities('Value &#x20AC;.'));

		# Cas d'Entités Échappées et Inconnues
		$this->assertSame('Test &unknown; value', $this->slugify->replaceUnicodeToHtmlEntities('Test &unknown; value'));
		$this->assertSame('Value &#99', $this->slugify->replaceUnicodeToHtmlEntities('Value &#99'));
	}

	public function testDecodeSpaces()
	{
		$this->assertSame('test test', $this->slugify->decodeSpaces('test test'));
		$this->assertSame('test test', $this->slugify->decodeSpaces('test&nbsp;test'));
		$this->assertSame('test test', $this->slugify->decodeSpaces('test&thinsp;test'));
		$this->assertSame('test test', $this->slugify->decodeSpaces('test&#8239;test'));
	}

	public function testEncodeSpaces()
	{
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{00A0}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{202F}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{2007}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{2002}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{2003}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{2004}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{2005}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{2006}»<"));
		$this->assertSame('>test&nbsp;»<', $this->slugify->encodeSpaces(">test\u{3000}»<"));
	}

	public function testUcfirst()
	{
		// Chaîne ASCII classique
		$this->assertSame('Hello', $this->slugify->ucfirst('hello'));
		$this->assertSame('Hello world', $this->slugify->ucfirst('hello world'));

		// Première lettre déjà en majuscule
		$this->assertSame('Hello', $this->slugify->ucfirst('Hello'));
		$this->assertSame('Hello World', $this->slugify->ucfirst('Hello World'));

		// Chaîne vide
		$this->assertSame('', $this->slugify->ucfirst(''));

		// Commence par un chiffre
		$this->assertSame('123abc', $this->slugify->ucfirst('123abc'));

		// Commence par un symbole
		$this->assertSame('#hashtag', $this->slugify->ucfirst('#hashtag'));

		// Caractères accentués (UTF-8)
		$this->assertSame('Éléphant', $this->slugify->ucfirst('éléphant'));
		$this->assertSame('À la maison', $this->slugify->ucfirst('à la maison'));
		$this->assertSame('Çà va', $this->slugify->ucfirst('çà va'));
		$this->assertSame('Österreich', $this->slugify->ucfirst('österreich'));

		// Chaîne en majuscules
		$this->assertSame('HELLO', $this->slugify->ucfirst('HELLO'));

		// Chaîne avec espace initial
		$this->assertSame(' hello', $this->slugify->ucfirst(' hello'));

		// Texte mixte (emojis, lettres)
		$this->assertSame('😊hello', $this->slugify->ucfirst('😊hello'));
		$this->assertSame('😊Hello', $this->slugify->ucfirst('😊Hello'));
	}

	public function testCaseTitle()
	{
		// Cas simples
		$this->assertSame('', $this->slugify->caseTitle(''));
		$this->assertSame('Hello World', $this->slugify->caseTitle('Hello World'));
		$this->assertSame('Hello World', $this->slugify->caseTitle('hello world'));
		$this->assertSame('Hello World', $this->slugify->caseTitle('HELLO WORLD'));
		$this->assertSame('Hello World', $this->slugify->caseTitle('HeLLo WoRLD'));
		$this->assertSame('Hello   World', $this->slugify->caseTitle('hello   world'));
		$this->assertSame(' Hello World ', $this->slugify->caseTitle(' hello world '));
		$this->assertSame('Version 2.0 Finale', $this->slugify->caseTitle('version 2.0 finale'));

		// Accents et caractères spéciaux
		$this->assertSame('Éléphant Rose', $this->slugify->caseTitle('éléphant rose'));
		$this->assertSame('À La Maison', $this->slugify->caseTitle('à la maison'));
		$this->assertSame('Ça Va Bien', $this->slugify->caseTitle('ça va bien'));

		// Phrases mixtes
		$this->assertSame('Bonjour, Le Monde!', $this->slugify->caseTitle('bonjour, le monde!'));
		$this->assertSame('123 Soleil', $this->slugify->caseTitle('123 soleil'));
		$this->assertSame('Chapitre 2: Le Début', $this->slugify->caseTitle('chapitre 2: le début'));

		// Espaces multiples et bords
		$this->assertSame('Hello   World', $this->slugify->caseTitle('hello   world'));
		$this->assertSame(' Hello', $this->slugify->caseTitle(' hello'));
		$this->assertSame('Hello ', $this->slugify->caseTitle('hello '));

		// Déjà bien formé
		$this->assertSame('Bonjour Le Monde', $this->slugify->caseTitle('Bonjour le monde'));

		// Emojis et symboles
		$this->assertSame('😊 Hello World', $this->slugify->caseTitle('😊 hello world'));
		$this->assertSame('Hello 🌍 World', $this->slugify->caseTitle('hello 🌍 world'));
		$this->assertSame('😎', $this->slugify->caseTitle('😎'));

		// Cas avec tirets et underscores (le comportement dépend du besoin exact)
		$this->assertSame('Jean-Pierre', $this->slugify->caseTitle('jean-pierre'));
		$this->assertSame('Jean_Pierre', $this->slugify->caseTitle('jean_pierre'));
		$this->assertSame("Jean-Luc Picard", $this->slugify->caseTitle("jean-luc picard"));

		// Accents et caractères multibytes
		$this->assertSame('Éléphant À L’école', $this->slugify->caseTitle('éléphant à l’école'));
		$this->assertSame('Ça Va Bien', $this->slugify->caseTitle('çA vA bIen'));
		$this->assertSame('Österreich Ist Schön', $this->slugify->caseTitle('österreich ist schön'));
	}

	public function testCapitalize(): void
	{
		// apostrophes simples et typographiques
		$this->assertSame("L'École Des Femmes", $this->slugify->capitalize("l'école des femmes"));
		$this->assertSame("L'Été En Provence", $this->slugify->capitalize("l'été en provence"));
		$this->assertSame("L’Arc En Ciel", $this->slugify->capitalize("l’arc en ciel")); // apostrophe typographique

		// noms composés avec tirets
		$this->assertSame("Jean-Luc Picard", $this->slugify->capitalize("jean-luc picard"));
		$this->assertSame("Anne-Marie Dupont", $this->slugify->capitalize("anne-marie dupont"));

		// noms avec particules françaises
		$this->assertSame("De La Fontaine", $this->slugify->capitalize("de la fontaine"));
		$this->assertSame("Van Der Sar", $this->slugify->capitalize("van der sar"));
		$this->assertSame("Du Pont", $this->slugify->capitalize("du pont"));

		// majuscules initiales sur lettres accentuées
		$this->assertSame("Élève Studieux", $this->slugify->capitalize("élève studieux"));
		$this->assertSame("À La Mode", $this->slugify->capitalize("à la mode"));

		// mélange complexe
		$this->assertSame("L'Église-Du-Sacré-Coeur", $this->slugify->capitalize("l'église-du-sacré-coeur"));
		$this->assertSame("Jean De La Fontaine", $this->slugify->capitalize("jean de la fontaine"));
	}

	public function testSanitizeOneLineStrings(): void
	{
		# Normalisation des espaces simples et insécables
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello World")); // insécable (U+00A0)
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello World")); // fine non-breaking space (U+202F)
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello World")); // thin space (U+2009)
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello World")); // em-space (U+2003)
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello  World")); // figure space multiple

		# Suppression des balises HTML simples
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("<b>Hello</b> World"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("
			<p>Hello</p>
			<p>World</p>
		"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("<div><span>Hello  World</span></div>"));

		# Remplacement des <br> par un espace
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello<br>World"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello<br/>World"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello<BR>World")); // insensible à la casse

		# Suppression des multiples espaces
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello    World"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello          World")); // mix d’espaces normaux et spéciaux

		# Retours à la ligne, tabulations, etc.
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello\nWorld"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello\r\nWorld"));
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("Hello\tWorld"));

		# Mélange HTML + espaces + retour
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("<p>Hello</p>\n<br> World"));

		# Cas extrêmes
		$this->assertSame('', $this->slugify->sanitizeOneLineStrings("   <br>   ")); // juste des espaces et retours
		$this->assertSame('', $this->slugify->sanitizeOneLineStrings("<p> </p>")); // juste un espace insécable dans balise
		$this->assertSame("Hello World", $this->slugify->sanitizeOneLineStrings("<p>Hello&nbsp;&nbsp;World</p>")); // double espace HTML
		$this->assertSame('', $this->slugify->sanitizeOneLineStrings('')); // vide
		$this->assertSame('', $this->slugify->sanitizeOneLineStrings("<p></p>")); // HTML vide
	}

	public function testRemoveAccent(): void
	{
		# Accents français classiques
		$this->assertSame('e', $this->slugify->removeAccent('é'));
		$this->assertSame('e', $this->slugify->removeAccent('è'));
		$this->assertSame('e', $this->slugify->removeAccent('ê'));
		$this->assertSame('e', $this->slugify->removeAccent('ë'));
		$this->assertSame('a', $this->slugify->removeAccent('à'));
		$this->assertSame('u', $this->slugify->removeAccent('ù'));
		$this->assertSame('i', $this->slugify->removeAccent('ï'));
		$this->assertSame('c', $this->slugify->removeAccent('ç'));
		$this->assertSame('C', $this->slugify->removeAccent('Ç'));
		$this->assertSame('A', $this->slugify->removeAccent('À'));

		# Lettres capitalisées avec accents
		$this->assertSame('ECOLE', $this->slugify->removeAccent('ÉCOLE'));
		$this->assertSame('AEROPORT', $this->slugify->removeAccent('AÉROPORT'));
		$this->assertSame('FRANCAIS', $this->slugify->removeAccent('FRANÇAIS'));

		# Ligatures et caractères spéciaux européens
		$this->assertSame('ae', $this->slugify->removeAccent('æ'));
		$this->assertSame('AE', $this->slugify->removeAccent('Æ'));
		$this->assertSame('oe', $this->slugify->removeAccent('œ'));
		$this->assertSame('OE', $this->slugify->removeAccent('Œ'));

		# Accents espagnols, portugais, italiens, allemands
		$this->assertSame('nino', $this->slugify->removeAccent('niño'));
		$this->assertSame('NINO', $this->slugify->removeAccent('NIÑO'));
		$this->assertSame('cao', $this->slugify->removeAccent('cão'));
		$this->assertSame('universita', $this->slugify->removeAccent('università'));
		$this->assertSame('uber', $this->slugify->removeAccent('über'));
		$this->assertSame('strasse', $this->slugify->removeAccent('straße')); // ß → ss
		$this->assertSame('GROSS', $this->slugify->removeAccent('GROẞ')); // ẞ → SS

		# Lettres d’Europe de l’Est
		$this->assertSame('Lodz', $this->slugify->removeAccent('Łódź'));
		$this->assertSame('Warszawa', $this->slugify->removeAccent('Warszawa'));
		$this->assertSame('Szczecin', $this->slugify->removeAccent('Szczecin'));
		$this->assertSame('Praha', $this->slugify->removeAccent('Praha'));
		$this->assertSame('Budapest', $this->slugify->removeAccent('Budapest'));

		# Grec et cyrillique : ne pas transformer
		$this->assertSame('Athina', $this->slugify->removeAccent('Αθήνα'));
		$this->assertSame('Moskva', $this->slugify->removeAccent('Москва'));

		# Caractères neutres (pas de modification attendue)
		$this->assertSame('Hello World!', $this->slugify->removeAccent('Hello World!'));
		$this->assertSame('1234567890', $this->slugify->removeAccent('1234567890'));
		$this->assertSame('Test_', $this->slugify->removeAccent('Test_'));

		# Mélange complet
		$this->assertSame('Francais cafe creme a l’aeroport', $this->slugify->removeAccent('Français café crème à l’aéroport'));

		# Cas extrêmes : chaînes vides ou nulles
		$this->assertSame('', $this->slugify->removeAccent(''));
		$this->assertSame(' ', $this->slugify->removeAccent(' '));

		# Unicode combiné (ex: e + ´ séparés)
		$this->assertSame('e', $this->slugify->removeAccent("e\u{0301}"));
		$this->assertSame('E', $this->slugify->removeAccent("E\u{0301}"));
	}

	public function testClean()
	{
		# Cas de base
		$this->assertSame('bonjour-tout-le-monde', $this->slugify->clean('Bonjour tout le monde'));
		$this->assertSame('ceci-est-un-test', $this->slugify->clean('Ceci est un test.'));
		$this->assertSame('multi-espace', $this->slugify->clean('  multi    espace  '));
		$this->assertSame('avec-underscore', $this->slugify->clean('avec_underscore'));
		$this->assertSame('mix-underscore-espace', $this->slugify->clean('mix_underscore espace'));

		# Cas avec majuscules et accents
		$this->assertSame('voila-l-ete', $this->slugify->clean('Voilà l’été'));
		$this->assertSame('eleve', $this->slugify->clean('Élève'));
		$this->assertSame('a-b-c', $this->slugify->clean('À B Ç'));

		# Ponctuation et symboles
		$this->assertSame('hello-world', $this->slugify->clean('Hello, world!'));
		$this->assertSame('c-est-bien', $this->slugify->clean("C’est bien"));
		$this->assertSame('don-t-stop', $this->slugify->clean("Don't stop"));
		$this->assertSame('email-test-example-com', $this->slugify->clean('Email test@example.com'));
		$this->assertSame('100-sur', $this->slugify->clean('100% sûr'));
		$this->assertSame('1-2-3', $this->slugify->clean('1/2/3'));

		# Glue personnalisé
		$this->assertSame('hello_world', $this->slugify->clean('Hello world', '_'));
		$this->assertSame('slug__test', $this->slugify->clean('Slug  test', '__')); // double glue possible

		# Multilingue
		$this->assertSame('athina', $this->slugify->clean('Αθήνα')); // grec
		$this->assertSame('moskva', $this->slugify->clean('Москва')); // cyrillique

		# Cas spéciaux
		$this->assertSame('bonjour', $this->slugify->clean('   Bonjour   ')); // trimming
		$this->assertSame('phrase-avec-tirets', $this->slugify->clean('Phrase avec --- tirets'));
		$this->assertSame('a-b', $this->slugify->clean('A   B'));
		$this->assertSame('x', $this->slugify->clean('X!@#$%^&*()')); // tout filtré sauf la lettre
		$this->assertSame('2025', $this->slugify->clean('2025'));
		$this->assertSame('version-1-2-3', $this->slugify->clean('Version 1.2.3'));
		$this->assertSame('url-http-www-example-com', $this->slugify->clean('URL: http://www.example.com'));

		# Espaces insécables et unicode
		$this->assertSame('bonjour-tout-le-monde', $this->slugify->clean("Bonjour\u{00A0}tout\u{2009}le\u{202F}monde"));
		$this->assertSame('texte-non-breakable', $this->slugify->clean("Texte\u{00A0}non\u{00A0}breakable"));

		# Cas étranges
		$this->assertSame('a', $this->slugify->clean('-a-'));
		$this->assertSame('', $this->slugify->clean('----'));
		$this->assertSame('n-a', $this->slugify->clean('N/A'));
		$this->assertSame('emoji', $this->slugify->clean('Emoji 😃'));
	}

	public function testConvertSymbols(): void
	{
		$this->assertSame('c', $this->slugify->clean('©', 'ERROR', true));
		$this->assertSame('tm', $this->slugify->clean('™', 'ERROR', true));
		$this->assertSame('r', $this->slugify->clean('®', 'ERROR', true));
		$this->assertSame('euro', $this->slugify->clean('€', 'ERROR', true));
		$this->assertSame('dollar', $this->slugify->clean('$', 'ERROR', true));
		// strip_tags remove lt but not remove gt
		//$this->assertSame('lt', $this->slugify->clean('<', 'ERROR', true));
		$this->assertSame('gt', $this->slugify->clean('>', 'ERROR', true));
		$this->assertSame('to', $this->slugify->clean('→', 'ERROR', true));
		$this->assertSame('love', $this->slugify->clean('♥', 'ERROR', true));
		$this->assertSame('star', $this->slugify->clean('★', 'ERROR', true));
		$this->assertSame('1/2', $this->slugify->clean('½', '/', true));
		$this->assertSame('plus minus', $this->slugify->clean('±', ' ', true));
		$this->assertSame('percent', $this->slugify->clean('%', 'ERROR', true));
		$this->assertSame('deg', $this->slugify->clean('°', 'ERROR', true));
		$this->assertSame('no', $this->slugify->clean('№', 'ERROR', true));
		$this->assertSame('and', $this->slugify->clean('&', 'ERROR', true));
		$this->assertSame('at', $this->slugify->clean('@', 'ERROR', true));
		$this->assertSame('cloud', $this->slugify->clean('☁', 'ERROR', true));
		$this->assertSame('l', $this->slugify->clean('ℓ', 'ERROR', true));
		$this->assertSame('m', $this->slugify->clean('ℳ', 'ERROR', true));

		Symbol::init();

		# Anglais
		Symbol::setLanguage('en');
		$this->assertSame('love', $this->slugify->clean('♥', 'ERROR', true));

		# Français
		Symbol::setLanguage('fr');
		$this->assertSame('pourcent', $this->slugify->clean('%', 'ERROR', true));
		$this->assertSame('plus ou moins', $this->slugify->clean('±', ' ', true));
		$this->assertSame('coeur', $this->slugify->clean('♥', 'ERROR', true));
		$this->assertSame('vers', $this->slugify->clean('→', 'ERROR', true));

		# Italien
		Symbol::setLanguage('it');
		$this->assertSame('piu o meno', $this->slugify->clean('±', ' ', true));
		$this->assertSame('gradi', $this->slugify->clean('°', 'ERROR', true));

		# Espagnol
		Symbol::setLanguage('es');
		$this->assertSame('porciento', $this->slugify->clean('%', 'ERROR', true));
		$this->assertSame('estrella', $this->slugify->clean('★', 'ERROR', true));

		# Allemand
		Symbol::setLanguage('de');
		$this->assertSame('plusminus', $this->slugify->clean('±', 'ERROR', true));
		$this->assertSame('liebe', $this->slugify->clean('♥', 'ERROR', true));

		# Fallback : langue inconnue = anglais
		Symbol::setLanguage('xx');
		$this->assertSame('plus-minus', $this->slugify->clean('±', '-', true));
		$this->assertSame('love-star-percent', $this->slugify->clean('♥ * %', '-', true));

		# Custom map
		Symbol::init([
			'en' => ['♥' => 'I love PHP'],
		]);
		$this->assertSame('i-love-php', $this->slugify->clean('♥', '-', true));
	}

	public function testFatTrim(): void
	{
		$this->assertSame('bonjour tout le monde', $this->slugify->trim("	Bonjour \u{00A0}tout \u{2009}le \u{202F} monde "));
		$this->assertSame('texte non breakable', $this->slugify->trim(" Texte	\u{00A0}non		\u{00A0} breakable	"));
	}

	public function testStrip(): void
	{
		# Cas de base : suppression complète de tous les tags
		$input = '<b>Hello</b> <i>world</i>!';
		$this->assertSame(' !', $this->slugify->strip($input));

		# Garder certaines balises (ici <b>)
		$input = '<b>Hello</b> <i>world</i>!';
		$this->assertSame('<b>Hello</b> !', $this->slugify->strip($input, '<b>'));

		# Supprimer les balises listées (mode disallow = true)
		$input = '<b>Hello</b> <i>world</i>!';
		$this->assertSame(' <i>world</i>!', $this->slugify->strip($input, '<b>', true));

		# Supprimer le contenu d’une balise
		$input = 'Text before <script>alert("xss")</script> text after';
		$this->assertSame('Text before  text after', $this->slugify->strip($input, '<script>', true, false));

		# Supprimer la balise mais garder le contenu
		$input = 'Text before <script>alert("xss")</script> text after';
		$this->assertSame('Text before alert("xss") text after', $this->slugify->strip($input, '<script>', true, true));

		# Garder plusieurs balises
		$input = '<b>Bold</b> and <i>italic</i> and <u>underlined</u>';
		$this->assertSame('<b>Bold</b> and <i>italic</i> and ', $this->slugify->strip($input, '<b><i>'));

		# Suppression imbriquée
		$input = '<div><span><b>Hello</b></span></div>';
		$this->assertSame('', $this->slugify->strip($input));

		# Balises déséquilibrées ou mal formées
		$input = '<b>Hello <i>world</b></i>';
		$this->assertSame('Hello world', $this->slugify->strip($input, '<b><i>', true, true, true));
		$this->assertSame('<b>Hello <i>world</i></b>', $this->slugify->strip($input, '<span>', true, true, true));
		$this->assertSame('Hello world', $this->slugify->strip($input, '', false, true, true));

		# Garder contenu mais supprimer balises interdites imbriquées
		$input = '<div><script>alert("oops")</script><p>ok</p></div>';
		$this->assertSame('<div>alert("oops")<p>ok</p></div>', $this->slugify->strip($input, '<script>', true, true));

		# Tags autorisés mais mal écrits
		$input = '<B>Hello</B><I>world</I>';
		$this->assertSame('<b>Hello</b>', $this->slugify->strip($input, '<b>'));
		$this->assertSame('<b>Hello</b>world', $this->slugify->strip($input, '<b>', false, true));

		# Try extract content
		$input = '
			<section>
				<h1>Articles</h1>
				<article>
					<article>
						<header>
							<h1>Titre</h1>
							<p>Auteur</p>
						</header>
						<p>Contenu</p>
						<footer>
							<p>
								<time datetime="2025-02-02">2 février 2025</time>
							</p>
					  </footer>
					</article>
				</article>
			</section>
		';
		$input = $this->slugify->strip($input, '<p><section><article>');
		$input = $this->slugify->strip($input, '<p>', false, true);
		$this->assertSame('<p>Contenu</p>', trim($input));

		# Suppression d’attributs non gérés (normalement ignorés)
		$input = '<a href="link.html" onclick="hack()">Click</a>';
		$this->assertSame('Click', $this->slugify->strip($input, '', false, true));
		$this->assertSame('<a href="link.html" onclick="hack()">Click</a>', $this->slugify->strip($input, '<a>')); // autorisé

		# Keep content avec désactivation globale
		$input = '<style>body{color:red;}</style>Keep me';
		$this->assertSame('Keep me', $this->slugify->strip($input, '<style>', true));

		# Multitags avec contenu mixte
		$input = '<div><p>Para <b>bold</b></p><script>malicious()</script></div>';
		$input = $this->slugify->strip($input, '<div>', true, true);
		$input = $this->slugify->strip($input, '<p><b>');
		$this->assertSame('<p>Para <b>bold</b></p>', $input);
	}

	public function testPregName(): void
	{
		// Valides – alphabet basique
		$this->assertTrue($this->slugify->pregName('Jean'));
		$this->assertTrue($this->slugify->pregName('A'));
		$this->assertTrue($this->slugify->pregName('Jean Pierre'));
		$this->assertTrue($this->slugify->pregName('Jean-Pierre'));

		// Valides – accents latins
		$this->assertTrue($this->slugify->pregName('Élodie'));
		$this->assertTrue($this->slugify->pregName('Chloë'));
		$this->assertTrue($this->slugify->pregName('Renée'));
		$this->assertTrue($this->slugify->pregName('José'));
		$this->assertTrue($this->slugify->pregName('François'));
		$this->assertTrue($this->slugify->pregName('Müller'));
		$this->assertTrue($this->slugify->pregName('García'));
		$this->assertTrue($this->slugify->pregName('Łukasz'));
		$this->assertTrue($this->slugify->pregName('Sławomir'));
		$this->assertTrue($this->slugify->pregName('Åsa'));
		$this->assertTrue($this->slugify->pregName('Jørgen'));
		$this->assertTrue($this->slugify->pregName('Zoë'));
		$this->assertTrue($this->slugify->pregName('Maël'));

		// Valides – grec & cyrillique
		$this->assertTrue($this->slugify->pregName('Νικόλαος'));
		$this->assertTrue($this->slugify->pregName('Αννα-Μαρία'));
		$this->assertTrue($this->slugify->pregName('Иван'));
		$this->assertTrue($this->slugify->pregName('Мария-Анна'));

		// Valides – apostrophes et variantes
		$this->assertTrue($this->slugify->pregName("O'Connor"));     // apostrophe droite '
		$this->assertTrue($this->slugify->pregName("D’Arcy"));       // apostrophe typographique ’
		$this->assertTrue($this->slugify->pregName("L‘Hôpital"));    // apostrophe ouvrante ‘
		$this->assertTrue($this->slugify->pregName("D´Angelo"));     // accent aigu ´ utilisé comme séparateur
		$this->assertTrue($this->slugify->pregName("D`Angelo"));     // accent grave `
		$this->assertTrue($this->slugify->pregName("Jean d’Arc"));   // espace + apostrophe typographique
		$this->assertTrue($this->slugify->pregName("Jean-Claude Van Damme"));

		// Invalides – caractères non autorisés
		$this->assertFalse($this->slugify->pregName(''));                   // vide
		$this->assertFalse($this->slugify->pregName('123'));                // chiffres
		$this->assertFalse($this->slugify->pregName('Jean3'));              // lettres + chiffres
		$this->assertFalse($this->slugify->pregName('Jean_Claude'));        // underscore
		$this->assertFalse($this->slugify->pregName('Jean. Claude'));       // point
		$this->assertFalse($this->slugify->pregName('Jean, Claude'));       // virgule
		$this->assertFalse($this->slugify->pregName('Jean/Claude'));        // slash
		$this->assertFalse($this->slugify->pregName('Jean@Claude'));        // @
		$this->assertFalse($this->slugify->pregName('Jean&Claude'));        // &
		$this->assertFalse($this->slugify->pregName('🧑‍💻'));                 // emoji
		$this->assertFalse($this->slugify->pregName('§ (bad name ° 123'));  // ton exemple

		// Invalides – espaces / séparateurs mal placés
		$this->assertFalse($this->slugify->pregName(' Jean'));              // espace initial
		$this->assertFalse($this->slugify->pregName('Jean '));              // espace final
		$this->assertFalse($this->slugify->pregName('Jean  Pierre'));       // double espace
		$this->assertFalse($this->slugify->pregName('Jean--Pierre'));       // double tiret
		$this->assertFalse($this->slugify->pregName("O''Connor"));          // double apostrophe
		$this->assertFalse($this->slugify->pregName("Jean-"));              // tiret final
		$this->assertFalse($this->slugify->pregName("-Jean"));              // tiret initial
		$this->assertFalse($this->slugify->pregName("O'"));                 // apostrophe finale
		$this->assertFalse($this->slugify->pregName("'O"));                 // apostrophe initiale
		$this->assertFalse($this->slugify->pregName("Jean--"));             // séparateurs non suivis de lettres
		$this->assertFalse($this->slugify->pregName("Jean  "));             // espaces de fin multiples

		// Tiret normal (autorisé) → true
		$this->assertTrue($this->slugify->pregName('Jean-Marc'));

		// Invalides – points médians, etc. (non prévus par la regex)
		$this->assertFalse($this->slugify->pregName('Jean·Marc'));          // point médian
		$this->assertFalse($this->slugify->pregName('Jean–Marc'));          // en dash

		// Tiret insécable U+2011 (refusé) → false
		$this->assertFalse($this->slugify->pregName("Jean\u{2011}Marc"));
		// En dash U+2013 (refusé) → false
		$this->assertFalse($this->slugify->pregName("Jean\u{2013}Marc"));
		// Espace insécable U+00A0 (refusé) → false
		$this->assertFalse($this->slugify->pregName("Jean\u{00A0}Marc"));

		// Limites – très longs noms/plusieurs segments (toujours valides)
		$this->assertTrue($this->slugify->pregName("Maximilien-Alexandre Théodore"));
		$this->assertTrue($this->slugify->pregName("Jean Paul George Ringo"));
	}

	public function testSubstrText(): void
	{
		// Vide / seulement balises → chaîne vide
		$this->assertSame('', $this->slugify->substrText(''));
		$this->assertSame('', $this->slugify->substrText('<b></b>'));
		$this->assertSame('', $this->slugify->substrText('   <i>  </i>   '));

		// Plus court que la limite → retourne tout
		$this->assertSame('Salut le monde', $this->slugify->substrText('Salut le monde', 300));
		$this->assertSame('Salut le monde', $this->slugify->substrText('   Salut le monde   ', 50));

		// Coupure exactement sur un espace à l’offset → coupe avant l’espace
		$this->assertSame('Lorem', $this->slugify->substrText('Lorem ipsum dolor sit amet', 5));

		// Coupure au prochain espace après l’offset (pas de coupe en milieu de mot)
		$this->assertSame('Lorem ipsum', $this->slugify->substrText('Lorem ipsum dolor sit amet', 6));
		$this->assertSame('Lorem ipsum dolor', $this->slugify->substrText('Lorem ipsum dolor sit amet', 12));

		// Aucun espace après l’offset → retourne tout
		$this->assertSame('Sup', $this->slugify->substrText('Superlongword', 3));
		$this->assertSame('Hel', $this->slugify->substrText('<p>Hello<br>world</p>', 3)); // strip_tags supprime <br>

		// Entités HTML → décodées avant traitement
		$this->assertSame('Tom & Jerry', $this->slugify->substrText('Tom &amp; Jerry &eacute;patent', 8));
		$this->assertSame('© 2024 ACME', $this->slugify->substrText('&copy; 2024 ACME – all rights reserved', 11));

		// Espaces insécables (&nbsp;) → normalisés par decodeSpaces puis traités
		$this->assertSame('Hello', $this->slugify->substrText("Hello&nbsp;world", 5));
		$this->assertSame('Hello world', $this->slugify->substrText("Hello&nbsp;world", 50));

		// Trim + strip tags
		$this->assertSame('Salut monde', $this->slugify->substrText('  <p>Salut <strong>monde</strong></p>  ', 100));
		$this->assertSame('Salut', $this->slugify->substrText('  <p>Salut <em>monde</em></p>  ', 5));

		// Limite exactement égale à la longueur → retourne tout
		$this->assertSame('Hi there', $this->slugify->substrText('Hi there', 8));

		// Multibyte UTF-8 (ne coupe pas au milieu d’un mot, cherche l’espace suivant)
		$this->assertSame('Élève', $this->slugify->substrText('Élève très motivé', 2));
		$this->assertSame('Élève très', $this->slugify->substrText('Élève très motivé', 7));

		// Apostrophes/ponctuation inoffensives avant l’espace
		$this->assertSame("L'appli fonctionne", $this->slugify->substrText("L'appli fonctionne bien aujourd'hui", 18));

		// Long texte avec coupure tardive (grands offsets)
		$this->assertSame('Lorem ipsum dolor sit amet, consectetur', $this->slugify->substrText('Lorem ipsum dolor sit amet, consectetur adipiscing elit', 32));

		// Aucun espace du tout (après nettoyage) → texte complet
		$this->assertSame('Éléphant', $this->slugify->substrText('Éléphant 🦄 Magique', 5));
	}

	public function testSearchSqlCleaner(): void
	{
		// Vide / balises vides → vide
		$this->assertSame('', $this->slugify->searchSqlCleaner(''));
		$this->assertSame('', $this->slugify->searchSqlCleaner('<b></b>'));
		$this->assertSame('', $this->slugify->searchSqlCleaner('   <i>   </i>   '));

		// HTML simple → strip_tags + trim
		$this->assertSame('Bonjour monde', $this->slugify->searchSqlCleaner('<p>Bonjour <strong>monde</strong></p>'));

		// Entités HTML → décodées puis nettoyées
		$this->assertSame("L'apero c'est super", $this->slugify->searchSqlCleaner("<p>L&#39;ap&eacute;ro&nbsp;&mdash; c&apos;est… super&nbsp;!</p>"));

		// Entités nommées/numériques résiduelles → supprimées
		$this->assertSame('AT T', $this->slugify->searchSqlCleaner('AT&amp;T &unknown; &#169;'));

		// Apostrophes variées → normalisées en '
		$this->assertSame("L'ecole d'ete", $this->slugify->searchSqlCleaner("L’école d’été"));
		$this->assertSame("O'Connor", $this->slugify->searchSqlCleaner("O’Connor"));
		$this->assertSame("D'Angelo", $this->slugify->searchSqlCleaner("D´Angelo"));
		$this->assertSame("D'Angelo", $this->slugify->searchSqlCleaner("D`Angelo"));

		// Accents retirés (removeAccent)
		$this->assertSame('Francois Muller', $this->slugify->searchSqlCleaner('François Müller'));

		// Chiffres conservés
		$this->assertSame('Version 2 0 1', $this->slugify->searchSqlCleaner('Version 2.0.1'));

		// Tirets supprimés (OCR / coupe-mots) → concaténation
		$this->assertSame('JeanMarc', $this->slugify->searchSqlCleaner('Jean-Marc'));
		$this->assertSame('inter national', $this->slugify->searchSqlCleaner("inter-\nnational"));

		// URL / ponctuation → réduites à mots/nombres
		$this->assertSame('https example com path query 1', $this->slugify->searchSqlCleaner('https://example.com/path?query=1'));

		// Emoji et symboles → retirés
		$this->assertSame('Hello world', $this->slugify->searchSqlCleaner('Hello 😀 world ™ © ®'));

		// Multiples espaces → collapse à un seul
		$this->assertSame('un deux trois', $this->slugify->searchSqlCleaner('un     deux     trois'));

		// Espaces insécables &nbsp; &thinsp; &nbsp;… → normalisés puis collapsés
		$this->assertSame('Hello world', $this->slugify->searchSqlCleaner("Hello&nbsp;&thinsp;world"));

		// Script/style → balises supprimées, contenu nettoyé
		$this->assertSame("alert 'x'", $this->slugify->searchSqlCleaner("<script>alert('x');</script>"));

		// Mélange balises + entités + accents + tirets
		$this->assertSame("L'appli marche tresbien", $this->slugify->searchSqlCleaner("<em>L’appli</em> marche&nbsp;— très-bien !"));

		// Cas avec underscores/pipe/slash → supprimés
		$this->assertSame('foo bar baz 42', $this->slugify->searchSqlCleaner('foo_bar|baz/42'));

		// Grec / cyrillique (retirés si removeAccent ne translittère pas) → remplacés par espaces
		$this->assertSame('Lorem Nikolaos', $this->slugify->searchSqlCleaner('Lorem Νικόλαος'));
		$this->assertSame('Ivan Ivan', $this->slugify->searchSqlCleaner('Ivan Иван'));

		// Cas limites : texte très long + coupures diverses
		$this->assertSame("Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor vitae", $this->slugify->searchSqlCleaner("Lorem <b>ipsum</b> dolor &amp; sit — amet; consectetur «adipiscing» elit… sed—do—eiusmod tempor&nbsp;vitae"));
	}

	public function testCamelCase(): void
	{
		// Simple lowercase
		$this->assertSame('helloWorld', $this->slugify->camelCase('hello world'));
		$this->assertSame('helloWorld', $this->slugify->camelCase('hello-world'));
		$this->assertSame('helloWorld', $this->slugify->camelCase('hello_world'));

		// Multiple words
		$this->assertSame('helloBeautifulWorld', $this->slugify->camelCase('hello beautiful world'));
		$this->assertSame('helloBeautifulWorld', $this->slugify->camelCase('HELLO BEAUTIFUL WORLD'));

		// Extra spaces / mixed separators
		$this->assertSame('helloWorld', $this->slugify->camelCase('  hello   world  '));
		$this->assertSame('helloWorld', $this->slugify->camelCase('hello-world'));
		$this->assertSame('helloFoo', $this->slugify->camelCase('hello_foo'));
		$this->assertSame('helloBar', $this->slugify->camelCase('hello   bar'));

		// All caps with delimiters
		$this->assertSame('userAccountId', $this->slugify->camelCase('USER_ACCOUNT_ID'));
		$this->assertSame('testExample', $this->slugify->camelCase('TEST-EXAMPLE'));
		$this->assertSame('mySqlDatabase', $this->slugify->camelCase('my_SQL_database'));

		// Accents or unicode letters
		$this->assertSame('jeanPierre', $this->slugify->camelCase('jean-pierre'));
		$this->assertSame('eleveMotive', $this->slugify->camelCase('élève motivé'));

		// Digits mixed in
		$this->assertSame('version2Beta', $this->slugify->camelCase('version 2 beta'));
		$this->assertSame('x2Factor', $this->slugify->camelCase('x2 factor'));

		// Symbols cleaned out
		$this->assertSame('helloWorld', $this->slugify->camelCase('hello@world!'));
		$this->assertSame('fooBarBaz', $this->slugify->camelCase('foo#bar$baz'));

		// Empty / only separators
		$this->assertSame('', $this->slugify->camelCase(''));
		$this->assertSame('', $this->slugify->camelCase('-_-'));
	}

	public function testPascalCase(): void
	{
		// Simple words
		$this->assertSame('HelloWorld', $this->slugify->pascalCase('hello world'));
		$this->assertSame('HelloWorld', $this->slugify->pascalCase('hello-world'));
		$this->assertSame('HelloWorld', $this->slugify->pascalCase('hello_world'));

		// Multiple words
		$this->assertSame('HelloBeautifulWorld', $this->slugify->pascalCase('hello beautiful world'));
		$this->assertSame('HelloBeautifulWorld', $this->slugify->pascalCase('HELLO BEAUTIFUL WORLD'));

		// Mixed separators / extra spaces
		$this->assertSame('HelloWorldFooBar', $this->slugify->pascalCase('  hello-world_foo  bar  '));

		// camelCase → uppercased first letter
		$this->assertSame('Helloworld', $this->slugify->pascalCase('helloWorld'));

		// Uppercase + underscores
		$this->assertSame('UserAccountId', $this->slugify->pascalCase('USER_ACCOUNT_ID'));
		$this->assertSame('TestExample', $this->slugify->pascalCase('TEST-EXAMPLE'));
		$this->assertSame('MySqlDatabase', $this->slugify->pascalCase('my_SQL_database'));

		// Accents / unicode letters
		$this->assertSame('JeanPierre', $this->slugify->pascalCase('jean-pierre'));
		$this->assertSame('EleveMotive', $this->slugify->pascalCase('élève motivé'));

		// Digits mixed in
		$this->assertSame('Version2Beta', $this->slugify->pascalCase('version 2 beta'));
		$this->assertSame('X2Factor', $this->slugify->pascalCase('x2 factor'));

		// Symbols cleaned out
		$this->assertSame('HelloWorld', $this->slugify->pascalCase('hello@world!'));
		$this->assertSame('FooBarBaz', $this->slugify->pascalCase('foo#bar$baz'));

		// Empty / only separators
		$this->assertSame('', $this->slugify->pascalCase(''));
		$this->assertSame('', $this->slugify->pascalCase('-_-'));
	}
}