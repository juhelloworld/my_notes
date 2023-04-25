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

    deleteNote($conn, $_GET["note_id"]);

    //Process connect error
} catch (Exception $e) {
    $return["error"] = 'Connection failure in myfeed @ 24';
    //json_encode($return);
    echo json_encode($return);
    exit();
}


function deleteNote($conn, $note_id){

    if(!is_numeric($note_id)){
        return null;
    }

    $note_id = intval($note_id);

    if ($note_id == 0 ) {
        $sql = "DELETE FROM notes_table";
    } else {
        $sql = "DELETE FROM notes_table WHERE note_id = $note_id";
    }

$result = mysqli_query($conn, $sql);

    if (!$result) {
        $return["error"] = 'Failed to delete note from database';

        echo json_encode($return);
        exit();
    }

    $return["success"] = 'Note deleted successfully';

    echo json_encode($return);
};
