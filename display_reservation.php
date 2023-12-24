<?php

session_start();

require 'utils/format_date.php';

function enqueue_display_styles() {
    wp_enqueue_style('display_styles', plugin_dir_url(__FILE__) . 'assets/styles/display.css');
}

add_action('wp_enqueue_scripts', 'enqueue_display_styles');

function prepare_whatsapp_message($reservation) {
    $message = "Dados do orçamento:\n";
    $message .= "Data de retirada: " . $reservation['start_date'] . "\n";
    $message .= "Hora de retirada: " . $reservation['start_time'] . "\n";
    $message .= "Data de devolução: " . $reservation['end_date'] . "\n";
    $message .= "Hora de devolução: " . $reservation['end_time'] . "\n";
    if (isset($reservation['vehicle'])) {
        $message .= "Veículo: " . $reservation['vehicle']['cars'] . "\n";
        $message .= "Categoria: " . $reservation['vehicle']['category'] . "\n";
        $message .= "Preço por dia: R$ " . $reservation['vehicle']['price'] . "\n";
        $message .= "Preço total: R$ " . $reservation['total_price'] . "\n";
    }

    return urlencode($message);
}

function display_reservation() {
    if (isset($_SESSION['reservation'])) {
        $reservation = $_SESSION['reservation'];
        $message = prepare_whatsapp_message($reservation);
        ?>
        <div class="containerDisplay">
            <section class="sectionForm">
                <h3 class='title'>Resumo da reserva</h3>
                <p>
                    <strong>Data de retirada</strong> em <?= format_date($reservation['start_date']) ?>
                    às <?= $reservation['start_time'] ?>
                </p>
                <p>
                    <strong>Data de devolução</strong> em <?= format_date($reservation['end_date']) ?>
                    às <?= $reservation['end_time'] ?>
                </p>
                <?php if (isset($reservation['vehicle'])): ?>
                    <p><strong>Grupo: </strong> <?= $reservation['vehicle']['category'] ?></p>
                    <p><strong>Total de diárias: </strong> <?= $reservation['days'] ?></p>
                    <p><strong>Preço por dia: </strong>R$ <?= $reservation['vehicle']['price'] ?></p>
                    <p><strong>Valor total: </strong>R$ <?= $reservation['total_price'] ?></p>
                <?php endif; ?>
            </section>

            <aside class="asideForm">
                <h2>Finalizar reserva</h2>
                <form class="form" method="$_POST" action="">
                    <input type='text' value='Nome' name='name' required>
                    <input type='text' value='E-mail' name='email' required>
                    <input type='text' value='Telefone' name='phone' required>
                    <input type='submit' value='Finalizar'>
                </form>
            </aside>
        </div>
        <?php
    }
}

add_shortcode('display_reservation', 'display_reservation');

?>