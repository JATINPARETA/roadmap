<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semester = $_POST['semester'];

    if (!empty($semester)) {
        header("Location: semester" . $semester . ".php");
        exit();
    } else {
        echo "Please select a semester.";
    }
}
?>
