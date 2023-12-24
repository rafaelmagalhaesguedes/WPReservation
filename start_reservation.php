<?php

session_start();

function enqueue_reservation_styles() {
    wp_enqueue_style('reservation_styles', plugin_dir_url(__FILE__) . 'assets/styles/reservation.css');
}

add_action('wp_enqueue_scripts', 'enqueue_reservation_styles');


function startReservation() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $_SESSION['reservation'] = array(
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_date' => $end_date,
            'end_time' => $end_time,
        );

        // End output buffering
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Redirect to the reservation page
        wp_redirect( home_url( 'reservas2' ) );
        exit;
    }

    return null;
}

add_action('init', 'startReservation');
