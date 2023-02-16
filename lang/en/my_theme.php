<?php
// Każdy plik powinien mieć w nagłówku GPL i copyright - pomijamy to w tutorialach, ale naprawdę nie powinieneś tego pomijać.

// Ta linia chroni plik przed bezpośrednim dostępem z adresu URL.
defined('MOODLE_INTERNAL') || die();

// Opis wyświetlany w selektorze motywu administratora.
$string['choosereadme'] = 'Theme kristian is a child theme of Boost. It adds the ability to upload background photos.';
// Nazwa naszej wtyczki.
$string['pluginname'] = 'Kristian theme';
// Musimy dołączyć łańcuch lang dla każdego regionu bloku.
$string['region-side-pre'] = 'Right';
// Nazwa drugiej zakładki w ustawieniach motywu.
$string['advancedsettings'] = 'Advanced settings';
// Ustawienie kolorów marki.
$string['brandcolor'] = 'Brand colour';
// Opis ustawienia koloru marki.
$string['brandcolor_desc'] = 'The accent colour.';
// Nazwa stron ustawień.
$string['configtitle'] = 'Kristian settings';
// Nazwa pierwszej zakładki ustawień.
$string['generalsettings'] = 'General settings';
// Ustawienia plików predefiniowanych.
$string['presetfiles'] = 'Additional theme preset files';
// Tekst pomocy dla plików presetów.
$string['presetfiles_desc'] = 'Preset files can be used to dramatically alter the appearance of the theme. See <a href=https://docs.moodle.org/dev/Boost_Presets>Boost presets</a> for information on creating and sharing your own preset files, and see the <a href=http://moodle.net/boost>Presets repository</a> for presets that others have shared.';
// Predefiniowane ustawienie.
$string['preset'] = 'Theme preset';
// Predefiniowany tekst pomocy.
$string['preset_desc'] = 'Pick a preset to broadly change the look of the theme.';
// Surowe ustawienie SCSS.
$string['rawscss'] = 'Raw SCSS';
// Surowy tekst pomocy ustawień SCSS.
$string['rawscss_desc'] = 'Use this field to provide SCSS or CSS code which will be injected at the end of the style sheet.';
// Surowe początkowe ustawienie SCSS.
$string['rawscsspre'] = 'Raw initial SCSS';
// Surowy tekst pomocy dotyczący początkowych ustawień SCSS.
$string['rawscsspre_desc'] = 'In this field you can provide initialising SCSS code, it will be injected before everything else. Most of the time you will use this setting to define variables.';
