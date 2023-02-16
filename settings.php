<?php

// Każdy plik powinien mieć w nagłówku GPL i copyright - pomijamy to w tutorialach, ale naprawdę nie powinieneś tego pomijać.

// Ta linia chroni plik przed bezpośrednim dostępem z adresu URL.
defined('MOODLE_INTERNAL') || die();

// To jest używane do wydajności, nie musimy wiedzieć o tych ustawieniach na każdej stronie w Moodle, tylko kiedy
// patrzymy na strony ustawień administratora.
if ($ADMIN->fulltree) {

    // Boost zapewnia ładną stronę ustawień, która dzieli ustawienia na osobne zakładki. Chcemy to tutaj wykorzystać.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingkristian', get_string('configtitle', 'my_theme'));

    // Każda strona to karta — pierwsza to zakładka „General”.
    $page = new admin_settingpage('my_theme_general', get_string('generalsettings', 'my_theme'));

    // Zreplikuj ustawienie wstępne z boost.
    $name = 'my_theme/preset';
    $title = get_string('preset', 'my_theme');
    $description = get_string('preset_desc', 'my_theme');
    $default = 'default.scss';

    // Wymieniamy pliki w naszym własnym obszarze plików, aby dodać je do listy rozwijanej. Dostarczymy własną funkcję do ładowania wszystkich ustawień wstępnych z właściwych ścieżek.
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'my_theme', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // To są wbudowane ustawienia wstępne z Boost.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Ustawienia plików predefiniowanych.
    $name = 'my_theme/presetfiles';
    $title = get_string('presetfiles','my_theme');
    $description = get_string('presetfiles_desc', 'my_theme');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
                                                  array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Zmienna $brand-color.
     // Używamy pustej wartości domyślnej, ponieważ domyślny kolor powinien pochodzić z ustawienia wstępnego.
    $name = 'my_theme/brandcolor';
    $title = get_string('brandcolor', 'my_theme');
    $description = get_string('brandcolor_desc', 'my_theme');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Musisz dodać stronę po zdefiniowaniu wszystkich ustawień!
    $settings->add($page);

    // Zaawansowane ustawienia.
    $page = new admin_settingpage('my_theme_advanced', get_string('advancedsettings', 'my_theme'));

    // Surowy SCSS do umieszczenia przed treścią.
    $setting = new admin_setting_configtextarea('my_theme/scsspre',
                                                get_string('rawscsspre', 'my_theme'), get_string('rawscsspre_desc', 'my_theme'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Surowy SCSS do dołączenia po treści.
    $setting = new admin_setting_configtextarea('my_theme/scss', get_string('rawscss', 'my_theme'),
                                                get_string('rawscss_desc', 'my_theme'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
