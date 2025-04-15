<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Possible Diseases</title>
    <link rel="stylesheet" href="/STYLES/Styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="navbar">
        <a href= "Index.php"class="logo">HealthMD</a>
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
    <div class="container">

        <form method="post">
            Age: <input type="number" name="age" required><br>
            Sex:
            <select name="sex" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>
            Symptoms (comma-separated): <input type="text" name="symptoms" placeholder="e.g. Fever,Cough" required><br>
            <input type="submit" value="Check">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $symptoms = $_POST['symptoms'];

            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "checkup"; // Replace with your DB name

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Call the stored procedure
                $stmt = $conn->prepare("CALL GetPossibleDiseases(:age, :sex, :symptoms)");
                $stmt->bindParam(':age', $age, PDO::PARAM_INT);
                $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
                $stmt->bindParam(':symptoms', $symptoms, PDO::PARAM_STR);
                $stmt->execute();

                // Show results
                echo "<h2>Possible Diseases:</h2>";
                echo "<table><tr><th>Disease</th></tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>" . htmlspecialchars($row['Disease']) . "</td></tr>";
                }

                echo "</table>";
                $stmt->closeCursor(); // Important to clear results for next queries
            } catch(PDOException $e) {
                echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
            }
        }
        ?>

    </div>

</body>
</html>
