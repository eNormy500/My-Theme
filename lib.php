<?php

// Każdy plik powinien mieć w nagłówku GPL i copyright - pomijamy to w tutorialach, ale naprawdę nie powinieneś tego pomijać.

// Ta linia chroni plik przed bezpośrednim dostępem z adresu URL.
defined('MOODLE_INTERNAL') || die();

// Będziemy tutaj dodawać wywołania zwrotne w miarę dodawania funkcji do naszego motywu.
function my_theme_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        // Nadal ładujemy domyślne pliki predefiniowane bezpośrednio z motywu boost. Nie ma sensu ich powielać.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        // Nadal ładujemy domyślne pliki predefiniowane bezpośrednio z motywu boost. Nie ma sensu ich powielać.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');

    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'my_theme', 'preset', 0, '/', $filename))) {
        // Ten plik predefiniowany został pobrany z obszaru plików dla my_theme, a nie theme_boost (patrz wiersz powyżej).
        $scss .= $presetfile->get_content();
    } else {
        // Awaria bezpieczeństwa - być może nowe instalacje itp.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }
    // Pre CSS - to jest ładowane PO dowolnym prescss z ustawienia, ale przed głównym scss.
    $pre = file_get_contents($CFG->dirroot . '/theme/kristian/scss/pre.scss');
    // Post CSS - jest ładowany PO głównym scss, ale przed dodatkowym scss z ustawienia.
    $post = file_get_contents($CFG->dirroot . '/theme/kristian/scss/post.scss');
    // Połącz je razem.
    return $pre . "\n" . $scss . "\n" . $post;
}
