<?php
require_once 'SC.php';

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
</head>
<body>
    <h2>Select Symptoms</h2>
    <form method="POST" action="">
        <?php foreach ($symptomsList as $symptom): ?>
            <label>
                <input type="checkbox" name="symptoms[]" value="<?= htmlspecialchars($symptom['Symptom_Name']) ?>">
                <?= htmlspecialchars($symptom['Symptom_Name']) ?>
            </label><br>
        <?php endforeach; ?>
        <br>
        <button type="submit">Check Diseases</button>
    </form>

    <?php if (!empty($diseases)): ?>
        <h2>Possible Diseases</h2>
        <?php foreach ($diseases as $disease): ?>
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <strong><?= htmlspecialchars($disease['Disease_Name']) ?></strong><br>
                Description: <?= nl2br(htmlspecialchars($disease['Description'])) ?><br>
                Classification: <?= htmlspecialchars($disease['Classification']) ?><br>

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
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No diseases found for selected symptoms.</p>
    <?php endif; ?>
</body>
</html>
