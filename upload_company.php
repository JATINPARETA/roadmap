<?php
include 'db_config.php';

$message = "";

// File upload logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year = $_POST['year'];
    $company = $_POST['company'];
    $role = $_POST['role'];

    $target_dir = "uploads/";
    $file_name = basename($_FILES["job_profile"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['pdf'];

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["job_profile"]["tmp_name"], $target_file)) {
            // Store the correct path in the `job_profile` column
            $stmt = $conn->prepare("INSERT INTO company_info (year, company, role, job_profile) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $year, $company, $role, $target_file);

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
        $message = "Invalid file type. Only PDF is allowed.";
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
    <h1>Admin - Upload Company Info</h1>
    <nav>
        <ul>
            <li><a href="placement.php">Back to Placement</a></li>
        </ul>
    </nav>
</header>

<section>
    <h2>Upload Company Info</h2>

    <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>

    <form action="upload_company.php" method="post" enctype="multipart/form-data">
        
        <label>Year:</label>
        <input type="number" name="year" required>

        <label>Company:</label>
        <input type="text" name="company" required>

        <label>Role:</label>
        <input type="text" name="role" required>

        <label>Upload Job Profile (PDF):</label>
        <input type="file" name="job_profile" accept=".pdf" required>

        <button type="submit">Upload</button>
    </form>
</section>

</body>
</html>
