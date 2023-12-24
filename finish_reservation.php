<?php

session_start();

function calculate_reservation() {
    if (isset($_POST['vehicle_index']) && isset($_SESSION['reservation'])) {
        $vehicles = array(
            array('image' => 'assets/images/grupa-a.png', 'cars' => 'Kwid, Uno, Mobi ou similar', 'category' => 'Grupo A - Hatch Compacto', 'price' => 190.89),
            array('image' => 'assets/images/grupo-b.png', 'cars' => 'Argo, Onix, HB20 ou similar', 'category' => 'Grupo B - Hatch', 'price' => 220.55),
            array('image' => 'assets/images/grupo-c.png', 'cars' => 'Cronos, Onix plus, HB20s ou similar', 'category' => 'Grupo C - Sedan', 'price' => 280.55),
            array('image' => 'assets/images/grupo-d.png', 'cars' => 'Renegade, Duster, Creta ou similar', 'category' => 'Grupo D - SUV', 'price' => 350.55),
            array('image' => 'assets/images/grupo-e.png', 'cars' => 'Chevrolet Spin ou Fiat Doblò', 'category' => 'Grupo E - Mini Van', 'price' => 350.55),
            array('image' => 'assets/images/grupo-f.png', 'cars' => 'S10, Ranger, Hillux ou similar', 'category' => 'Grupo F - 4x4', 'price' => 450.55),
        );

        $vehicle_index = $_POST['vehicle_index'];
        $vehicle = $vehicles[$vehicle_index];

        $start_date = new DateTime($_SESSION['reservation']['start_date']);
        $end_date = new DateTime($_SESSION['reservation']['end_date']);
        $interval = $start_date->diff($end_date);

        $days = $interval->days;
        $price_per_day = $vehicle['price'];

        $total_price = $days * $price_per_day;

        $_SESSION['reservation']['total_price'] = $total_price;
        $_SESSION['reservation']['vehicle'] = $vehicle;
        $_SESSION['reservation']['days'] = $days;

        // End output buffering
        if (ob_get_length()) {
            ob_end_clean();
        }

        if (function_exists('wp_redirect')) {
            wp_redirect(home_url('reserva3'));
        } else {
            // Fallback behavior if wp_redirect() is not available
            header("Location: " . home_url('reserva3'));
            exit;
        }
    }
}

calculate_reservation();

function complete_reservation() {

    $vehicles = array(
        array('image' => 'assets/images/grupo-a.png', 'cars' => 'Kwid, Uno, Mobi ou similar', 'category' => 'Grupo A - Compacto', 'price' => 190.89),
        array('image' => 'assets/images/grupo-b.png', 'cars' => 'Argo, Onix, HB20 ou similar', 'category' => 'Grupo B - Hatch', 'price' => 220.55),
        array('image' => 'assets/images/grupo-c.png', 'cars' => 'Cronos, Onix plus, HB20s ou similar', 'category' => 'Grupo C - Sedan', 'price' => 280.55),
        array('image' => 'assets/images/grupo-d.png', 'cars' => 'Renegade, Duster, Creta ou similar', 'category' => 'Grupo D - SUV', 'price' => 350.55),
        array('image' => 'assets/images/grupo-e.png', 'cars' => 'Chevrolet Spin ou Fiat Doblò', 'category' => 'Grupo E - Mini Van', 'price' => 350.55),
        array('image' => 'assets/images/grupo-f.png', 'cars' => 'S10, Ranger, Hillux ou similar', 'category' => 'Grupo F - 4x4', 'price' => 450.55),
    );

    ob_start(); ?>

    <div class="container">
        <h2>Escolha o grupo de carros</h2>
        <form class="form-category" method="post" action="">
            <?php foreach ($vehicles as $index => $vehicle): ?>
                <div class="card">
                    <?php 
                    $image_path = plugin_dir_path(__FILE__) . $vehicle['image'];
                    if (file_exists($image_path)) {
                        $image_url = plugin_dir_url(__FILE__) . $vehicle['image'];
                        echo "<img src='{$image_url}' alt='{$vehicle['cars']}'>";
                    } else {
                        echo "<p>Image not found</p>";
                    }
                    ?>
                    <h3><?php echo $vehicle['category']; ?></h3>
                    <h6><?php echo $vehicle['cars'] ?></h6>
                    <p>*Sua reserva garante um dos modelos de carro acima, estando sujeito à disponibilidade da locadora.</p>
                    <div class="price">
                        <span>Apartir de</span>
                        <span class='price-vehicle'>R$ <?php echo $vehicle['price']; ?> /dia</span>
                        <input type="hidden" name="vehicle_index" value="<?php echo $index; ?>">
                        <input type="hidden" name="vehicle_category" value="<?php echo $vehicle['category']; ?>">
                        <input class="button-continue" type="submit" value="Escolher Grupo">
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>


    <?php return ob_get_clean();
}

add_shortcode('complete_reservation', 'complete_reservation');

?>