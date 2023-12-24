<?php
/*
Plugin Name: Vehicle Reservation
Description: A plugin to calculate vehicle reservations
Version: 1.0
Author: Rafael M.
*/

require 'start_reservation.php';
require 'finish_reservation.php';
require 'display_reservation.php';

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
