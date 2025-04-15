<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/STYLES/Styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <title>HealthMD</title>
</head>
<body>

    <div class="navbar">
        <strong class="logo">HealthMD</strong>
        <div class="dropdown">
            <a href="checker.php" class="dropbtn">Symptom Checker</a>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">Conditions</a>
            <div class="dropdown-content">
                <a href="#">Fever</a>
                <a href="#">Fatigue</a>
                <a href="#">Cough</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">Drugs & Supplements</a>
            <div class="dropdown-content">
                <a href="#">Drug 1</a>
                <a href="#">Drug 2</a>
                <a href="#">Drug 3</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">Well-Being</a>
            <div class="dropdown-content">
                <a href="#">Well-Being 1</a>
                <a href="#">Well-Being 2</a>
                <a href="#">Well-Being 3</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">Find a Doctor</a>
            <div class="dropdown-content">
                <a href="#">Doctor 1</a>
                <a href="#">Doctor 2</a>
                <a href="#">Doctor 3</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">More</a>
            <div class="dropdown-content">
                <a href="#">Option 1</a>
                <a href="#">Option 2</a>
                <a href="#">Option 3</a>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once("db_connect.php"); // Include your DB connection

        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $symptoms = $_POST['symptoms'];

        try {
            $stmt = $conn->prepare("CALL GetPossibleDiseases(:age, :sex, :symptoms)");
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindParam(':symptoms', $symptoms, PDO::PARAM_STR);
            $stmt->execute();

            echo "<table><tr><th>Possible Diseases</th></tr>";
            $resultsFound = false;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultsFound = true;
                echo "<tr><td>" . htmlspecialchars($row['Disease']) . "</td></tr>";
            }
            echo "</table>";

            if (!$resultsFound) {
                echo "<p style='text-align:center; color:gray;'>No diseases matched your input.</p>";
            }

            $stmt->closeCursor(); // Clean up after stored procedure
        } catch (PDOException $e) {
            echo "<p style='text-align:center; color:red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>

</body>
</html>
