<?php
include 'db_config.php';

$message = "";

// File upload logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];
    $type = $_POST['type'];
    $unit = isset($_POST['unit']) ? $_POST['unit'] : null;

    $target_dir = "uploads/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['pdf', 'ppt', 'pptx'];

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO study_material (semester, subject_code, file_type, unit, file_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssis", $semester, $subject, $type, $unit, $target_file);

            if ($stmt->execute()) {
                $message = "File uploaded successfully!";
            } else {
                $message = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Failed to upload file.";
        }
    } else {
        $message = "Invalid file type. Only PDF, PPT, and PPTX are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Upload - BCA Roadmap</title>
    <link rel="stylesheet" href="admin_upload.css?v=1.0">
</head>
<body>

<header>
    <h1>Admin - Upload Syllabus or Study Material</h1>
    <nav>
        <ul>
            <li><a href="semester1.php">Semester 1</a></li>
            <li><a href="semester2.php">Semester 2</a></li>
            <li><a href="semester3.php">Semester 3</a></li>
        </ul>
    </nav>
</header>

<section>
    <h2>Upload Files</h2>

    <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>

    <form action="admin_upload.php" method="post" enctype="multipart/form-data">
        
        <label>Semester:</label>
        <select name="semester" required>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
            <option value="3">Semester 3</option>
        </select>

        <label>Subject:</label>
        <select name="subject" required>
            <!-- Semester 1 Subjects -->
            <optgroup label="Semester 1">
                <option value="CAP173">PROGRAMMING METHODOLOGIES-LABORATORY</option>
                <option value="PEL200">ENGLISH COMMUNICATION SKILLS</option>
                <option value="CHE110">ENVIRONMENTAL STUDIES</option>
                <option value="CAP171">FUNDAMENTALS OF INFORMATION TECHNOLOGY-LABORATORY</option>
                <option value="CAP170">FUNDAMENTALS OF INFORMATION TECHNOLOGY</option>
                <option value="MTH136">DISCRETE STRUCTURES</option>
                <option value="CAP172">PROGRAMMING METHODOLOGIES</option>
            </optgroup>
            
            <!-- Semester 2 Subjects -->
            <optgroup label="Semester 2">
                <option value="CAP200">DATABASE MANAGEMENT SYSTEMS</option>
                <option value="CAP202">OBJECT ORIENTED PROGRAMMING</option>
                <option value="CAP256">COMPUTER NETWORKS</option>
                <option value="CAP257">COMPUTER NETWORKS-LABORATORY</option>
                <option value="CAP268">COMPUTER SYSTEM ARCHITECTURE</option>
                <option value="CAP280">DATABASE MANAGEMENT SYSTEMS-LABORATORY</option>
                <option value="CAP281">OBJECT ORIENTED PROGRAMMING-LABORATORY</option>
                <option value="PEL204">Upper Intermediate Communication Skills</option>
            </optgroup>

            <!-- Semester 3 Subjects -->
            <optgroup label="Semester 3">
                <option value="CAP213">PRINCIPLES OF OPERATING SYSTEMS</option>
                <option value="CAP214">FUNDAMENTALS OF WEB PROGRAMMING</option>
                <option value="CAP267">DATA STRUCTURES</option>
                <option value="CAP282">DATA STRUCTURES-LABORATORY</option>
                <option value="CAP283">FUNDAMENTALS OF WEB PROGRAMMING-LABORATORY</option>
                <option value="PES209">SOFT SKILLS</option>
                <option value="ECE281">ARDUINO FOR THE BEGINNERS</option>
                <option value="MKT301">Marketing</option>
            </optgroup>
        </select>

        <label>Type:</label>
        <select name="type" id="type-select" required onchange="toggleUnitSelection()">
            <option value="syllabus">Syllabus</option>
            <option value="material">Study Material</option>
        </select>

        <div id="unit-selection" style="display: none;">
            <label>Unit:</label>
            <select name="unit">
                <option value="1">Unit 1</option>
                <option value="2">Unit 2</option>
                <option value="3">Unit 3</option>
                <option value="4">Unit 4</option>
                <option value="5">Unit 5</option>
                <option value="6">Unit 6</option>
            </select>
        </div>

        <label>Select File:</label>
        <input type="file" name="file" required>

        <button type="submit">Upload</button>
    </form>
</section>

<!-- Script to show/hide unit selection -->
<script>
    function toggleUnitSelection() {
        const typeSelect = document.getElementById('type-select');
        const unitSelection = document.getElementById('unit-selection');
        unitSelection.style.display = (typeSelect.value === 'material') ? 'block' : 'none';
    }
</script>

</body>
</html>
