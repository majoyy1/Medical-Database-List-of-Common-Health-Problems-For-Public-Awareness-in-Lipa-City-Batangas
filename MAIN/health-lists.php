<?php
// === PHP search logic at the top ===
$results = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['letter']) || isset($_GET['search']))) {
    // DB config
    $host = 'localhost';
	$db   = 'login_credentials';
	$user = 'root';
	$pass = '';
	$charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        $letter = $_GET['letter'] ?? '';
        $search = $_GET['search'] ?? '';

        $sql = "SELECT title, description FROM health_topics WHERE 1=1";
        $params = [];

        if (!empty($letter)) {
            $sql .= " AND title LIKE ?";
            $params[] = "$letter%";
        }

        if (!empty($search)) {
            $sql .= " AND title LIKE ?";
            $params[] = "%$search%";
        }

        $sql .= " ORDER BY title ASC LIMIT 50";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll();
    } catch (Exception $e) {
        $results = [['title' => 'Error', 'description' => 'Could not connect to the database']];
    }

    // If it's an AJAX request, return JSON and stop
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health Topics A-Z</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center text-blue-700 mb-6">Health Topics A-Z</h1>

        <div class="flex justify-center mb-6">
            <input id="searchInput" type="text" placeholder="Search health topics..." 
                   class="w-full max-w-md p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button onclick="fetchTopics()" 
                    class="bg-blue-600 text-white px-4 rounded-r-md hover:bg-blue-700">Search</button>
        </div>

        <div class="flex flex-wrap justify-center space-x-2 mb-8">
            <button onclick="filterByLetter('')" class="bg-gray-300 px-2 py-1 rounded hover:bg-gray-400">All</button>
            <script>
                for (let i = 65; i <= 90; i++) {
                    document.write(`<button onclick="filterByLetter('${String.fromCharCode(i)}')" class="bg-blue-100 hover:bg-blue-300 text-blue-800 font-semibold px-2 py-1 rounded m-1">${String.fromCharCode(i)}</button>`);
                }
            </script>
        </div>

        <ul id="results" class="space-y-4">
            <?php if (!isset($_GET['ajax'])): ?>
                <?php foreach ($results as $topic): ?>
                    <li class="bg-white p-4 rounded shadow-md hover:shadow-lg transition">
                        <h2 class="text-xl font-bold text-blue-700"><?= htmlspecialchars($topic['title']) ?></h2>
                        <p class="text-gray-700 mt-1"><?= htmlspecialchars($topic['description']) ?></p>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <script>
        let currentLetter = '';

        function fetchTopics() {
            const search = document.getElementById('searchInput').value;
            fetch(`?ajax=1&letter=${currentLetter}&search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('results');
                    list.innerHTML = '';
                    if (data.length === 0) {
                        list.innerHTML = '<li class="text-center text-gray-500">No topics found.</li>';
                    } else {
                        data.forEach(topic => {
                            const li = document.createElement('li');
                            li.className = "bg-white p-4 rounded shadow-md hover:shadow-lg transition";
                            li.innerHTML = `<h2 class='text-xl font-bold text-blue-700'>${topic.title}</h2><p class='text-gray-700 mt-1'>${topic.description}</p>`;
                            list.appendChild(li);
                        });
                    }
                });
        }

        function filterByLetter(letter) {
            currentLetter = letter;
            fetchTopics();
        }

        // Initial load
        fetchTopics();
    </script>
</body>
</html>
