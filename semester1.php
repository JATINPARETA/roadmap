<?php
include 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Semester 1 - Roadmap for BCA</title>
    <link rel="stylesheet" href="semester1.css?v=1.0">

</head>

<body>

<header>
    <h1>Semester 1 - Roadmap for BCA</h1>
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
    <h2>Semester 1 - Subjects</h2>
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
                ["code" => "CAP173", "name" => "PROGRAMMING METHODOLOGIES-LABORATORY", "credits" => 2],
                ["code" => "PEL200", "name" => "ENGLISH COMMUNICATION SKILLS", "credits" => 3],
                ["code" => "CHE110", "name" => "ENVIRONMENTAL STUDIES", "credits" => 2],
                ["code" => "CAP171", "name" => "FUNDAMENTALS OF INFORMATION TECHNOLOGY-LABORATORY", "credits" => 2],
                ["code" => "CAP170", "name" => "FUNDAMENTALS OF INFORMATION TECHNOLOGY", "credits" => 3],
                ["code" => "MTH136", "name" => "DISCRETE STRUCTURES", "credits" => 4],
                ["code" => "CAP172", "name" => "PROGRAMMING METHODOLOGIES", "credits" => 3]
            ];

            foreach ($subjects as $subject) {
                echo "<tr>
                    <td>{$subject['code']}</td>
                    <td>{$subject['name']}</td>
                    <td>{$subject['credits']}</td>
                    <td><a href='semester1.php?subject={$subject['code']}&type=syllabus#content-section' class='btn'>View Syllabus</a></td>
                    <td><a href='semester1.php?subject={$subject['code']}&type=material#content-section' class='btn'>View Study Material</a></td>
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

    // Show unit links for study material only
    if ($type === "material") {
        echo "<div class='unit-links'>";
        for ($i = 1; $i <= 6; $i++) {
            echo "<a href='semester1.php?subject=$subject&type=material&unit=$i#content-section'>Unit $i</a> ";
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
