<?php
require_once 'querys/SC.php';



$symptomChecker = new SymptomChecker();


$diseases = [];
$treatments = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['symptoms']) && is_array($_POST['symptoms'])) {
    $selectedSymptoms = $_POST['symptoms'];

 
    $diseases = $symptomChecker->getPossibleDiseases($selectedSymptoms);

    if (!empty($diseases)) {
        $diseaseIds = array_column($diseases, 'Disease_ID');
        $treatments = $symptomChecker->getTreatments($diseaseIds);
    }
}


$symptomsList = $symptomChecker->getSymptoms();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Symptom Checker</title>
    <link rel="stylesheet" href="../STYLES/Styles.css">
    <link rel="icon" href="../logo.png" type="image/png">
</head>
<body>
    <h2>Select Symptoms</h2>
    <form method="POST" action="">
    <div class="symptoms-box">
        <div class="symptom-grid">
            <?php foreach ($symptomsList as $symptom): ?>
                <label class="symptom-label">
                    <input type="checkbox" name="symptoms[]" value="<?= htmlspecialchars($symptom['Symptom_Name']) ?>">
                    <?= htmlspecialchars($symptom['Symptom_Name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="center-button">
        <button type="submit">Check Diseases</button>
    </div>
</form>


<?php if (!empty($diseases)): ?>
    <h2>Possible Diseases</h2>
    <div class="diseases-container">
        <?php foreach ($diseases as $disease): ?>
            <div class="disease-box">
                <strong><?= htmlspecialchars($disease['Disease_Name']) ?></strong><br>
                <p>Description: <?= nl2br(htmlspecialchars($disease['Description'])) ?></p>
                <p>Classification: <?= htmlspecialchars($disease['Classification']) ?></p>

                <?php
                $related = array_filter($treatments, fn($t) => $t['Disease_ID'] == $disease['Disease_ID']);
                if (!empty($related)):
                ?>
                    <strong>Recommended Treatments:</strong>
                    <ul>
                        <?php foreach ($related as $treat): ?>
                            <li><strong><?= htmlspecialchars($treat['Treatment_Name']) ?>:</strong>
                                <?= htmlspecialchars($treat['Description']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p class="no-diseases-message">No diseases found for selected symptoms.</p>
<?php endif; ?>
</body>
</html>
