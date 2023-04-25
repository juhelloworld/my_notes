<?php

$hostname = 'localhost';
$db_user = 'juliananotes';
$db_password = 'juliana@1240';
$db_name = 'app_notes';

try {
    $conn = @mysqli_connect($hostname, $db_user, $db_password, $db_name);
    if (mysqli_connect_error()) {
        throw new RuntimeException('mysqli connection error: ' . mysqli_connect_error());
    }
    mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

    editNomeById($conn, $_GET["note_id"]);

    //Process connect error
} catch (Exception $e) {
    $return["error"] = 'Connection failure in myfeed @ 24';
    //json_encode($return);
    echo json_encode($return);
    exit();
}

function editNomeById($conn, $note_id){

    $sql = "SELECT * FROM notes_table WHERE note_id = $note_id ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // extrai os dados do resultado da consulta em um array associativo
        $note_data = mysqli_fetch_assoc($result);
        // retorna os dados da nota
        echo json_encode($note_data);
        exit();
    } else {
        $return["error"] = 'Failed to select note from database';

        echo json_encode($return);
        exit();
    }

}

?>