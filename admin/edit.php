<?php
require_once "querys/disease.php";
require_once "querys/category.php";

$distemp = new CrudDisease();
$categ = new CrudCategory();
$categResult = $categ->read();

$diseaseData = []; 

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($_GET['editID'] == NULL)
        {
            throw new Exception("No ID Input.");
        }
        if (isset($_GET['editID']) && isset($_GET['auth']) && $_GET['auth'] == 1) {
            $temp = $distemp->checkDataById($_GET['editID']);
            if (empty($temp)) {
                throw new Exception("No data found for the given ID.");
            }
            $diseaseData = $temp[0];
        } else {
            throw new Exception("Invalid request.");
        }
    } 
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['Disease_ID'])) {
            if ($distemp->modifyData($_POST['Disease_ID'], $_POST['DiName'], $_POST['Description'], $_POST['Classification'], $_POST['Category'], $_POST['Note'])) {
                header("Location: list.php?success=2");
                exit;
            } else {
                throw new Exception("Failed to update data.");
            }
        }
    }
} catch (Exception $err) {
    $msg = "Error Request! " . $err->getMessage() . " Try Again.";
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

    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <form action="edit.php" method="post" class="edit-form">
        <h2 class="Title">Edit Disease Data</h2>
        <input type="hidden" id="DiName" name="Disease_ID" value="<?php echo isset($diseaseData['Disease_ID']) ? htmlspecialchars($diseaseData['Disease_ID']) : ''; ?>">

        <label for="name">Disease Name:</label>
        <input type="text" id="DiName" name="DiName" value="<?php echo isset($diseaseData['Disease_Name']) ? htmlspecialchars($diseaseData['Disease_Name']) : ''; ?>" required><br><br>

        <label for="Description">Description:</label>
        <textarea name="Description" id="description" required><?php echo isset($diseaseData['Description']) ? htmlspecialchars($diseaseData['Description']) : ''; ?></textarea><br><br>
        
        <label for="Classification">Classification:</label>
        <input type="text" id="classification" name="Classification" value="<?php echo isset($diseaseData['Classification']) ? htmlspecialchars($diseaseData['Classification']) : ''; ?>" required><br><br>

        <label for="Category">Category:</label>
        <select id="category" name="Category">
            <?php
            if (count($categResult) > 0) {
                foreach ($categResult as $row) {
                    $selected = (isset($diseaseData['Category_ID']) && $diseaseData['Category_ID'] == $row['Category_ID']) ? 'selected' : '';
                    echo "<option value='" . $row["Category_ID"] . "' $selected>" . $row["Category_Name"] . "</option>";
                }
            } else {
                echo "<option value='NULL'>No Category In List</option>";
            }
            ?>
        </select><br><br>
        
        <label for="Note">Note:</label>
        <textarea id="note" name="Note"><?php echo isset($diseaseData['Note']) ? htmlspecialchars($diseaseData['Note']) : ''; ?></textarea><br><br>

        <button type="submit" name="addData">Submit</button>
        <button type="reset">Reset</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='list.php'">Back</button>
    
            <!-- Delete Button Form -->
    <form class="delete-form" action="requests.php" method="post" onsubmit="return confirm('Delete this Data?');">
        <input type="hidden" id="DiName" name="DeleteID" value="<?php echo isset($diseaseData['Disease_ID']) ? htmlspecialchars($diseaseData['Disease_ID']) : ''; ?>">
        <button type="submit" class="delete-button">DELETE</button>
    </form>
    </form>


</body>
</html>
