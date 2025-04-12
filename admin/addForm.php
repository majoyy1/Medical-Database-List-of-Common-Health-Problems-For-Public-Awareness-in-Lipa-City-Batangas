<?php

require_once 'querys.php';
$categ = new CrudCategory();
$categResult = $categ->read();

$Disease = new CrudDisease();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addData'])) {
        $Disease->createData($_POST['DiName'], $_POST['Description'],  $_POST['Classification'],  $_POST['Category'], $_POST['Note'], );
        header("Location: addForm.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Disease</title>
</head>
<body>
    <h2>Add Disease Data</h2>
    <form method="post">

        <label for="name">Disease Name:</label>
        <input type="text" id="DiName" name="DiName" required><br><br>

        <label for="Description">Description:</label>
        <textarea name="Description" id="description" required></textarea><br><br>
        
        <label for="Classification">Classification</label>
        <input type="text" id="classification" name="Classification" required><br><br>

        <label for="Category">Category:</label>
        <select id="category" name="Category">
            <?php
            if (count($categResult) > 0) {
                foreach ($categResult as $row) {
                    echo "<option value='" .$row["Category_ID"] . "'>" . $row["Category_Name"] ."</option>";
                }    
            } else {
                echo "<option value='NULL'>No Category In List</option>";
            };
            ?>
        </select><br><br>
        
        <label for="Note">Note:</label>
        <textarea id="note" name="Note"></textarea><br><br>

        <button type="submit" name="addData">Submit</button>
        <button type="reset">Reset</button>

    </form>
</body>
</html>