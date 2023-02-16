<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/renderer.php');

class my_theme_core_course_renderer extends core_course_renderer {
    /**
     * Renders HTML to display one course module in a course section
     *
     * This includes link, content, availability, completion info and additional information
     * that module type wants to display (i.e. number of unread forum posts)
     *
     * This function calls:
     * {@link core_course_renderer::course_section_cm_name()}
     * {@link core_course_renderer::course_section_cm_text()}
     * {@link core_course_renderer::course_section_cm_availability()}
     * {@link core_course_renderer::course_section_cm_completion()}
     * {@link course_get_cm_edit_actions()}
     * {@link core_course_renderer::course_section_cm_edit_actions()}
     *
     * @param stdClass $course
     * @param completion_info $completioninfo
     * @param cm_info $mod
     * @param int|null $sectionreturn
     * @param array $displayoptions
     * @return string
     */
    public function course_section_cm($course, &$completioninfo, cm_info $mod, $sectionreturn, $displayoptions = array()) {
        $output = '';
        // Zwracamy pusty napis (ponieważ moduł kursu w ogóle się nie wyświetli)
         // Jeśli:
         // 1) Aktywność nie jest widoczna dla użytkowników
         // 2) „Availableinfo” jest puste, tj. aktywność była ukryte w sposób, który nie pozostawia żadnych informacji, np ikona oka.
        if (!$mod->is_visible_on_course_page()) {
            return $output;
        }

        $indentclasses = 'mod-indent';
        if (!empty($mod->indent)) {
            $indentclasses .= ' mod-indent-'.$mod->indent;
            if ($mod->indent > 15) {
                $indentclasses .= ' mod-indent-huge';
            }
        }

        $output .= html_writer::start_tag('div');

        if ($this->page->user_is_editing()) {
            $output .= course_get_cm_move($mod, $sectionreturn);
        }

        $output .= html_writer::start_tag('div', array('class' => 'mod-indent-outer w-100'));

        // Ten element div służy do wcięcia zawartości.
        $output .= html_writer::div('', $indentclasses);

        // Uruchom opakowanie dla rzeczywistej zawartości, aby zachować spójność wcięć
        $output .= html_writer::start_tag('div');

        // Wyświetl link do modułu (lub nic nie rób, jeśli moduł nie ma adresu URL)
        $cmname = $this->course_section_cm_name($mod, $displayoptions);

        if (!empty($cmname)) {
            // Rozpocznij div dla tytułu działania, wyłączając ikony edycji.
            $output .= html_writer::start_tag('div', array('class' => 'activityinstance'));
            $output .= $cmname;


            // Moduł może umieścić tekst po linku (np. nieprzeczytane forum)
            $output .= $mod->afterlink;

            // Zamykanie znacznika, który zawiera wszystko oprócz ikon edycji. Część zawartości modułu nie powinna być częścią tego.
            $output .= html_writer::end_tag('div'); // .activityinstance
        }

        // Jeśli jest treść, ale NIE ma linku (np. etykiety), wyświetl treść tutaj (PRZED ikonami). W takim przypadku wady muszą być wyświetlane po treści, aby miała większy sens wizualny i ze względu na dostępność, np. jeśli masz etykietę jednowierszową, powinna ona działać podobnie (przynajmniej w zakresie zamawiania) do działania.
        $contentpart = $this->course_section_cm_text($mod, $displayoptions);
        $url = $mod->url;
        if (empty($url)) {
            $output .= $contentpart;
        }

        $modicons = '';
        if ($this->page->user_is_editing()) {
            $editactions = course_get_cm_edit_actions($mod, $mod->indent, $sectionreturn);
            $modicons .= ' '. $this->course_section_cm_edit_actions($editactions, $mod, $displayoptions);
            $modicons .= $mod->afterediticons;
        }

        $modicons .= $this->course_section_cm_completion($course, $completioninfo, $mod, $displayoptions);

        if (!empty($modicons)) {
            $output .= html_writer::div($modicons, 'actions');
        }

        // Pokaż informacje o dostępności (jeśli moduł nie jest dostępny).
        $output .= $this->course_section_cm_availability($mod, $displayoptions);

        // Jeśli istnieje treść ORAZ łącze, wyświetl treść tutaj
         // (PO wszelkich ikonach). W przeciwnym razie był wyświetlany wcześniej
        if (!empty($url)) {
            $output .= $contentpart;
        }

        $output .= 'Added on date: ';
        $output .= html_writer::start_tag('strong');
        $output .= date_format_string($mod->added, '%Y-%m');
        $output .= html_writer::end_tag('strong');

        $output .= html_writer::end_tag('div'); // $indentclasses

        // Koniec wcięcia div.
        $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');
        return $output;
    }
}
