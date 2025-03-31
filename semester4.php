<?php
include 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Semester 4 - Roadmap for BCA</title>
    <link rel="stylesheet" href="semester1.css?v=1.0">
</head>

<body>

<header>
    <h1>Semester 4 - Roadmap for BCA</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="marking.php">Marking Scheme</a></li>
            <li><a href="placement.php">Placement Stats</a></li>
            <li><a href="cgpa.php">CGPA Calculator</a></li>
        </ul>
    </nav>
</header>

<section>
    <h2>Semester 4 - Subjects</h2>
    <table>
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Credits</th>
                <th>Syllabus</th>
                <th>Study Material</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subjects = [
                ["code" => "CAP314", "name" => "PRINCIPLES OF SOFTWARE ENGINEERING", "credits" => 3],
                ["code" => "CAP378", "name" => "ARTIFICIAL INTELLIGENCE", "credits" => 3],
                ["code" => "CAP379", "name" => "ARTIFICIAL INTELLIGENCE-LABORATORY", "credits" => 2],
                ["code" => "PEA204", "name" => "ANALYTICAL SKILLS", "credits" => 3],
            ];

            foreach ($subjects as $subject) {
                echo "<tr>
                    <td>{$subject['code']}</td>
                    <td>{$subject['name']}</td>
                    <td>{$subject['credits']}</td>
                    <td><a href='semester4.php?subject={$subject['code']}&type=syllabus#content-section' class='btn'>View Syllabus</a></td>
                    <td><a href='semester4.php?subject={$subject['code']}&type=material#content-section' class='btn'>View Study Material</a></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<!-- Specializations Section -->
<section>
    <h2>Semester 4 - Specializations</h2>

    <?php
    $specializations = [
        "Data Science" => [
            ["code" => "CAP482", "name" => "DATA EXPLORATION AND PREPARATION", "credits" => 3]
            
        ],
        "Cybersecurity" => [
            ["code" => "CS401", "name" => "Network Security", "credits" => 3],
            ["code" => "CS402", "name" => "Cryptography", "credits" => 3],
            ["code" => "CS403", "name" => "Ethical Hacking", "credits" => 3],
            ["code" => "CS404", "name" => "Security Audits", "credits" => 3]
        ],
        "Web Development" => [
            ["code" => "CAP916", "name" => "FRONT-END WEB UI FRAMEWORKS AND TOOLS", "credits" => 3]
        ],
        "Game Development" => [
            ["code" => "GD401", "name" => "Game Design", "credits" => 3],
            ["code" => "GD402", "name" => "Unity Development", "credits" => 3],
            ["code" => "GD403", "name" => "Graphics Programming", "credits" => 3],
            ["code" => "GD404", "name" => "Game Testing", "credits" => 3]
        ],
        "Application Development" => [
            ["code" => "AD401", "name" => "Mobile App Development", "credits" => 3],
            ["code" => "AD402", "name" => "Cross-Platform Apps", "credits" => 3],
            ["code" => "AD403", "name" => "App Testing", "credits" => 3],
            ["code" => "AD404", "name" => "API Integration", "credits" => 3]
        ],
        "Software Development" => [
            ["code" => "SD401", "name" => "Java Programming", "credits" => 3],
            ["code" => "SD402", "name" => "C++ Programming", "credits" => 3],
            ["code" => "SD403", "name" => "Version Control", "credits" => 3],
            ["code" => "SD404", "name" => "Software Testing", "credits" => 3]
        ]
    ];

    foreach ($specializations as $specName => $courses) {
        echo "<h3>$specName</h3>";
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Credits</th>
                    <th>Syllabus</th>
                    <th>Study Material</th>
                </tr>
              </thead>";
        echo "<tbody>";

        foreach ($courses as $course) {
            echo "<tr>
                    <td>{$course['code']}</td>
                    <td>{$course['name']}</td>
                    <td>{$course['credits']}</td>
                    <td><a href='semester4.php?subject={$course['code']}&type=syllabus#content-section' class='btn'>View Syllabus</a></td>
                    <td><a href='semester4.php?subject={$course['code']}&type=material#content-section' class='btn'>View Study Material</a></td>
                </tr>";
        }
        echo "</tbody>";
        echo "</table><br>";
    }
    ?>
</section>

<?php
// Display syllabus or study material
if (isset($_GET['subject']) && isset($_GET['type'])) {
    $subject = $_GET['subject'];
    $type = $_GET['type'];

    echo "<section id='content-section'>";
    echo "<h2>" . ucfirst($type) . " for $subject</h2>";

    if ($type === "material") {
        echo "<div class='unit-links'>";
        for ($i = 1; $i <= 6; $i++) {
            echo "<a href='semester4.php?subject=$subject&type=material&unit=$i#content-section'>Unit $i</a> ";
        }
        echo "</div>";
    }

    $sql = "SELECT * FROM study_material WHERE subject_code = '$subject' AND file_type = '$type'";

    if (isset($_GET['unit']) && $type === "material") {
        $unit = $_GET['unit'];
        $sql .= " AND unit = $unit";
        echo "<h2>Unit $unit for $subject</h2>";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filePath = $row['file_path'];
            echo "<div class='pdf-container'>";
            echo "<embed src='$filePath#toolbar=0' type='application/pdf'>";
            echo "</div>";
        }
    } else {
        echo "<p>No $type files found for this subject or unit.</p>";
    }

    echo "</section>";
}
?>

</body>
</html>
