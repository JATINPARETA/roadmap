<?php
if (isset($_POST['semester'])) {
    $semester = $_POST['semester'];
    header("Location: cgpasemester$semester.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGPA Calculator - Roadmap for BCA</title>
    <link rel="stylesheet" href="cgpa.css?v=1.0">
</head>
<body>

    <header>
        <h1>CGPA Calculator</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="placement.php">Placement</a></li>
                <li><a href="about.php">About BCA</a></li>
            </ul>
        </nav>
    </header>

    <section class="calculator">
        <h2>Select Your Semester</h2>
        <form method="POST">
            <label for="semester">Choose Semester:</label>
            <select name="semester" id="semester" required>
                <option value="" disabled selected>Select Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
            </select>
            <button type="submit">Proceed</button>
        </form>
    </section>
</body>
</html>
