<?php
require_once 'querys.php';
$categ = new CrudCategory();
$categResult = $categ->read();

$disease = new CrudDisease();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['DiName'])  && $_GET['request'] == 1) {
        
        echo $_POST['DiName'];
        echo $_POST['Description'];
        echo $_POST['Classification'];//for debbugging
        echo $_POST['Category'];
        echo $_POST['Note'];

        $dName = $disease->cleanData($_POST['DiName']);
        $dDescription = $disease->cleanData($_POST['Description']);
        $dClasssif = $disease->cleanData($_POST['Classification']);
        $dCat = $disease->cleanData($_POST['Category']);
        $dNote = $disease->cleanData($_POST['Note']);
        
        if ($disease->createData($dName, $dDescription, $dClasssif, $dCat, $dNote)) {
            $message = "The data has been added successfully!";

            echo "<script>
            alert('$message');
            window.location.href = 'list.php?success=1';
            </script>";
        } else {
            $message = "Error Adding Data";
            $redirect_url = "addForm.php";

            echo "<script>
            alert('$message');
            window.location.href = '';
            </script>";
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Disease</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <form action="addForm.php?request=1"  method="post" class="edit-form">
        <h2>Add Disease Data</h2>
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