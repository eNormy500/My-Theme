<?php

// Każdy plik powinien mieć w nagłówku GPL i copyright - pomijamy to w tutorialach, ale naprawdę nie powinieneś tego pomijać.

// Ta linia chroni plik przed bezpośrednim dostępem z adresu URL.
defined('MOODLE_INTERNAL') || die();

// $THEME jest zdefiniowany przed dołączeniem tej strony i możemy zdefiniować ustawienia, dodając właściwości do tego globalnego obiektu.

// Pierwszym potrzebnym ustawieniem jest nazwa motywu. Powinna to być ostatnia część nazwy komponentu, taka sama jak nazwa katalogu dla naszego motywu.
$THEME->name = 'kristian';

// To ustawienie zawiera listę arkuszy stylów, które chcemy uwzględnić w naszym motywie. Ponieważ chcemy używać SCSS zamiast CSS - nie będziemy
// wyświetlać żadnych arkuszy stylów. Gdybyśmy to zrobili, wymienilibyśmy nazwę pliku w folderze /style/ dla naszego motywu bez żadnych rozszerzeń plików css.
$THEME->sheets = [];

// Jest to ustawienie, którego można użyć do nadania stylu treści w edytorze tekstu TinyMCE. Nie jest to już domyślny edytor tekstu, a „Atto” nie potrzebuje tego ustawienia,
// więc niczego nie udostępnimy. Gdybyśmy to zrobili, działałoby to tak samo, jak poprzednie ustawienie - wyświetlanie pliku w folderze /styles/.
$THEME->editor_sheets = [];

// To jest krytyczne ustawienie. Chcemy dziedziczyć po theme_boost, ponieważ stanowi on doskonały punkt wyjścia dla motywów SCSS bootstrap4. Moglibyśmy tutaj dodać więcej niż jednego rodzica,
// aby dziedziczyć po wielu rodzicach, a gdybyśmy to zrobili, byłyby one przetwarzane w kolejności ważności (późniejsze motywy zastępują wcześniejsze). Rzeczy,
// które odziedziczymy po motywie nadrzędnym, obejmują style i szablony wąsów oraz niektóre (nie wszystkie) ustawienia.
$THEME->parents = ['boost'];

// Dok to sposób na usunięcie bloków ze strony i umieszczenie ich w trwałym ruchomym obszarze z boku strony. Boost nie obsługuje stacji dokującej,
// więc my też nie będziemy - ale spójrz na bootstrapbase, aby zobaczyć przykład motywu ze stacją dokującą.
$THEME->enable_dock = false;

// To jest stare ustawienie używane do ładowania określonego CSS dla niektórych JS YUI. Nie potrzebujemy go w motywach opartych na Boost,
// ponieważ Boost zapewnia domyślną stylizację dla używanych przez nas modułów YUI. Nie zaleca się używania tego ustawienia.
$THEME->yuicssmodules = array();

// Większość motywów użyje tego renderera, ponieważ jest to ten, który pozwala motywowi zastąpić każdy inny renderer.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// To jest lista bloków, które muszą istnieć na wszystkich stronach, aby ten motyw działał poprawnie. Na przykład baza bootstrap wymaga ustawień i bloków nawigacyjnych,
// ponieważ w przeciwnym razie nie byłoby możliwości nawigacji do wszystkich stron w Moodle. Boost nie wymaga tych bloków, ponieważ zapewnia inne sposoby nawigacji wbudowane w motyw.
$THEME->requiredblocks = '';

// Jest to funkcja, która mówi bibliotece bloków, aby nie używała bloku „Dodaj blok”. Nie chcemy tego w motywach opartych na doładowaniu,
// ponieważ wymusza to umieszczenie regionu bloku na stronie, gdy edycja jest włączona i zajmuje zbyt dużo miejsca.
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

// Jest to funkcja, która zwraca źródło SCSS dla głównego pliku w naszym motywie. Zastępujemy wersję boost, ponieważ chcemy,
// aby ustawienia wstępne przesłane do naszego własnego obszaru pliku motywu były wybierane z listy ustawień wstępnych.
$THEME->scss = function($theme) {
    return my_theme_get_main_scss_content($theme);
};
