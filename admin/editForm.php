<?php
require_once "querys.php";
$temp = new CrudDisease();
$categ = new CrudCategory();
$categResult = $categ->read();

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // -----------------Edit Request Data
        if (isset($_GET['usr']) && isset($_POST['EditDataID']) && $_POST['EditDataID'] != null ) {
            echo $_POST['EditDataID'];
            
        }

    } else {
        throw new Exception("Error Sending Requests! Contact Admin.");
    }
} catch (Exception $err) {             
    $msg = "Error Request! " .$err->getMessage() ." Try Again.";
    echo "<script>
        alert('$msg');
        window.location.href = 'list.php';
        </script>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Disease</title>
</head>
<body>
    <h2>Edit Disease Data</h2>
    <form action="addForm.php?request=1"  method="post">

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