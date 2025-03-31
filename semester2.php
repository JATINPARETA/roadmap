<?php
include 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Semester 2 - Roadmap for BCA</title>
    <link rel="stylesheet" href="semester1.css?v=1.0">
</head>

<body>

<header>
    <h1>Semester 2 - Roadmap for BCA</h1>
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
    <h2>Semester 2 - Subjects</h2>
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
                ["code" => "CAP200", "name" => "DATABASE MANAGEMENT SYSTEMS", "credits" => 3],
                ["code" => "CAP202", "name" => "OBJECT ORIENTED PROGRAMMING", "credits" => 3],
                ["code" => "CAP256", "name" => "COMPUTER NETWORKS", "credits" => 3],
                ["code" => "CAP257", "name" => "COMPUTER NETWORKS-LABORATORY", "credits" => 2],
                ["code" => "CAP268", "name" => "COMPUTER SYSTEM ARCHITECTURE", "credits" => 3],
                ["code" => "CAP280", "name" => "DATABASE MANAGEMENT SYSTEMS-LABORATORY", "credits" => 2],
                ["code" => "CAP281", "name" => "OBJECT ORIENTED PROGRAMMING-LABORATORY", "credits" => 2],
                ["code" => "PEL204", "name" => "Upper Intermediate Communication Skills", "credits" => 3]
            ];

            foreach ($subjects as $subject) {
                echo "<tr>
                    <td>{$subject['code']}</td>
                    <td>{$subject['name']}</td>
                    <td>{$subject['credits']}</td>
                    <td><a href='semester2.php?subject={$subject['code']}&type=syllabus#content-section' class='btn'>View Syllabus</a></td>
                    <td><a href='semester2.php?subject={$subject['code']}&type=material#content-section' class='btn'>View Study Material</a></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<?php
// Display syllabus or study material
if (isset($_GET['subject']) && isset($_GET['type'])) {
    $subject = $_GET['subject'];
    $type = $_GET['type'];

    echo "<section id='content-section'>";
    echo "<h2>" . ucfirst($type) . " for $subject</h2>";

    if ($type === "material") {
        // Display unit links for study material
        echo "<div class='unit-links'>";
        for ($i = 1; $i <= 6; $i++) {
            echo "<a href='semester2.php?subject=$subject&type=material&unit=$i#content-section'>Unit $i</a> ";
        }
        echo "</div>";
    }

    // Display PDFs based on selected unit
    $sql = "SELECT * FROM study_material WHERE subject_code = '$subject' AND file_type = '$type'";

    // Filter by selected unit only
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
        echo "<p class='no-files'>No $type files found for this subject or unit.</p>";
    }

    echo "</section>";
}
?>

</body>
</html>
