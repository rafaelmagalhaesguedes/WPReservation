<?php

session_start();

function enqueue_reservation_styles() {
    wp_enqueue_style('reservation_styles', plugin_dir_url(__FILE__) . '../assets/styles/reservation.css');
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

function vehicle_reservation() {

    ob_start(); ?>

    <div class="container-reservation">
        <div class="process">
            <form class="form" method="post" action="">
              
                <div class="retirada">

                    <div class="local-retirada">
                        <div>
                            <label>Local de retirada</label>
                            <input type="text" name="local" placeholder="Digite o local de retirada">
                        </div>
                        
                        <div>
                            <label>Data e hora retirada</label>
                            <div class="inputs">
                                <input type="date" name="start_date" require>
                                <input type="time" name="start_time" require>
                            </div>
                        </div>

                        
                        <div>
                            <label>Data e hora devolução</label>
                            <div class="inputs">
                                <input type="date" name="end_date" require>
                                <input type="time" name="end_time" require>
                            </div>
                        </div>

                        <input class="button" type="submit" value="Continuar">
                    </div>

                </div>
            </form>
        </div>
    </div>

    <?php return ob_get_clean();
}

add_shortcode('vehicle_reservation', 'vehicle_reservation');

?>