<?php
function format_date($date_string) {
    $date = new DateTime($date_string);
    $formatter = new IntlDateFormatter(
        'pt_BR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE
    );
    return $formatter->format($date);
}
?>