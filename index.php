<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotes - View Notes</title>
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
        <h1>MyNotes - View Notes</h1>
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <a href="index.php" class="btn btn-success">View Notes</a>
            </div>
            <div class="col-md-auto">
                <a href="create.php" class="btn btn-primary">Create a Note</a>
            </div>
            <div class="col-md-auto">
                <button class="btn btn-secondary" onclick="confirmActionAll()">Delete Notes</button>
            </div>
        </div>
        <br>
        <?php
        require_once('connection.php');
        $sql = "SELECT * FROM notes_table";
        $result = mysqli_query($connection, $sql);
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $count++;
        ?>
            <div class="alert <?php echo $count % 2 == 0 ? 'alert-dark' : 'alert-light'; ?>" role="alert">
                <h4 class="alert-heading">A note by <b><?php echo $row['name']; ?></b> on the category <b><i><?php echo $row['category']; ?></i></b></h4>
                Note added on: <?php echo $row['time_of_note_creation']; ?>
                ID: <?php echo $row['note_id']; ?>
                <hr>
                <p>
                    <b>To reply to <?php echo $row['name']; ?> you can email on: </b><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
                </p>
                <p>
                    <b>Note: </b><?php echo $row['note']; ?>
                </p>
                <a href="javascript:void(0)" class="text-decoration-none" onclick="confirmAction('<?php echo $row['note_id']; ?>')"><i class=" bi bi-trash"><img src="img/trash.svg" alt="Icon delete">Delete</i></a>

                <a href="create.php?note_id=<?php echo $row['note_id']; ?>" class="text-decoration-none" id="edit"><i class="bi bi-pencil-square"><img src="img/trash.svg" alt="Icon delete">Edit</i></a>

            </div>
        <?php
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>