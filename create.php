<?php

$hostname = 'localhost';
$db_user = 'juliananotes';
$db_password = 'juliana@1240';
$db_name = 'app_notes';

$note_data = null;

// when false means new, when true means edit a note
$note_edit = false;

if (is_numeric($_GET['note_id'])) {

    function editNoteById($conn, $note_id)
    {
        $sql = "SELECT * FROM notes_table WHERE note_id = $note_id ";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // extracts the data from the query result into an associative array
            $data = mysqli_fetch_assoc($result);


            return $data;

        } else {
            echo "Failed to select note from database";
            exit();
        }
    }

    try {
        $conn = @mysqli_connect($hostname, $db_user, $db_password, $db_name);
        if (mysqli_connect_error()) {
            throw new RuntimeException('mysqli connection error: ' . mysqli_connect_error());
        }
        mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

        $note_data = editNoteById($conn, $_GET["note_id"]);

        $note_edit = true;
        //Process connect error
    } catch (Exception $e) {
        $return["error"] = 'Connection failure in myfeed @ 24';
        //json_encode($return);
        echo json_encode($return);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotes - Create a Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/action.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <a href="index.php">
                    <img src="img/logo2.png" alt="MyNotes Logo" width="300px">
                </a>
            </div>
        </div>
        <h1>MyNotes - Create a Note</h1>
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <a href="index.php" class="btn btn-success">View Notes</a>
            </div>
            <div class="col-md-auto">
                <a href="create.php" class="btn btn-primary">Create a Note</a>
            </div>
        </div>
        <br>
        <br>
        <h3>Please share your thoughts below</h3>
        <form action="" method="POST">
            <p>
                <input type="text" name="name_of_user" id="user" placeholder="Please enter your name" class="form-control" required value="<?php echo $note_data["name"]; ?>">
            </p>
            <p>
                <input type="email" name="user_email" id="email" placeholder="Please enter your e-mail address" class="form-control" required value="<?php echo $note_data["email"]; ?>">
            </p>
            <p>
                Category
                <select name="Note_category" class="form-control" id="category" required>
                    <option <?php if ($note_data["category"] == "Sports") {
                                echo "selected";
                            } ?> value="Sports">Sports</option>
                    <option <?php if ($note_data["category"] == "Finance") {
                                echo "selected";
                            } ?> value="Finance">Finance</option>
                    <option <?php if ($note_data["category"] == "Entertainment") {
                                echo "selected";
                            } ?> value="Entertainment">Entertainment</option>
                    <option <?php if ($note_data["category"] == "Education") {
                                echo "selected";
                            } ?> value="Education">Education</option>
                    <option <?php if ($note_data["category"] == "Air Travel") {
                                echo "selected";
                            } ?> value="Air Travel">Air Travel</option>
                    <option <?php if ($note_data["category"] == "Recreation") {
                                echo "selected";
                            } ?> value="Recreation">Recreation</option>
                    <option <?php if ($note_data["category"] == "Celebrities") {
                                echo "selected";
                            } ?> value="Celebrities">Celebrities</option>
                    <option <?php if ($note_data["category"] == "Property") {
                                echo "selected";
                            } ?> value="Property">Property</option>
                </select>
            </p>
            <p>
                Note
                <textarea class="form-control" name="Note" id="note" rows="6"><?php echo $note_data["note"]; ?></textarea>
            </p>
            <p>
                <input type="submit" name="add_Note_button" value="Add Note" class="btn btn-secondary">
            </p>
        </form>
        <?php

        if (isset($_POST['add_Note_button'])) {


            $name_of_user = $_POST['name_of_user'];
            $user_email = $_POST['user_email'];
            $Note_category = $_POST['Note_category'];
            $Note = $_POST['Note'];
            $note_id = $_GET['note_id'];

            require_once('connection.php');

            // condition to insert or update data in db
            if ($note_edit == false) {
                $sql = "INSERT INTO notes_table (name,email,category,note,time_of_note_creation) VALUES ('$name_of_user', '$user_email','$Note_category','$Note', CURRENT_TIMESTAMP);";
            } else {
                $sql = "UPDATE `notes_table` SET `name`='$name_of_user',`email`='$user_email',`category`='$Note_category',`note`='$Note',`time_of_note_creation`= CURRENT_TIMESTAMP WHERE note_id = '$note_id'";
            }

            // if data has been entered
            if (mysqli_query($connection, $sql)) {
                if ($note_edit == true) {
                    header('Location: index.php');
                    exit();
                }
        ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Note Added</h4>
                    <hr>
                    <p>
                        <b>Name: </b><?php echo $name_of_user; ?>
                    </p>
                    <p>
                        <b>E-Mail: </b><?php echo $user_email; ?>
                    </p>
                    <p>
                        <b>Category: </b><?php echo $Note_category; ?>
                    </p>
                    <p>
                        <b>Note: </b><?php echo $Note; ?>
                    </p>
                    <a href="index.php" class="btn btn-success">View All Notes</a>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Note Not Added</h4>
                    <hr>
                    We are having issues adding your note to our database, please try again later!
                </div>
        <?php
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>