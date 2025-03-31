<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bca_roadmap";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Services - Roadmap for BCA</title>
    <link rel="stylesheet" href="placement.css?v=<?php echo time(); ?>"> <!-- Force latest CSS -->
</head>
<body>

<header>
    <h1>Placement Services - Lovely Professional University</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="cgpa.php">CGPA Calculator</a></li>
            <li><a href="about.php">About BCA</a></li>
        </ul>
    </nav>
</header>

<section class="services-container">
    <h2>How to Avail Placement Services at LPU</h2>
    <div class="grid-container">

        <!-- Steps Column -->
        <div class="grid-box">
            <h3>Steps to Register</h3><br>
            <ul>
                <li>Log in to your <strong>LPU UMS Dashboard</strong>.</li><br>
                <li>Click on <strong>UMS Navigation</strong> from the top menu.</li><br>
                <li>Select <strong>Placement Services</strong> from the dropdown list.</li><br>
                <li>Click on <strong>Register for Career Services</strong>.</li><br>
                <li>Fill in the required details:
                    <ul>
                        <li>Contact Information (Phone, Email)</li><br>
                        <li>Academic Details (CGPA, Current Semester)</li><br>
                        <li>Preferred Job Roles or Companies</li><br>
                    </ul>
                </li>
                <li>Pay the <strong>₹3000 registration fee</strong>.</li><br>
                <li>Receive a confirmation email after payment.</li><br>
            </ul>
        </div>

        <!-- Additional Info Column -->
        <div class="grid-box">
            <h3>📌 Additional Information</h3><br>
            <ul>
                <li><strong>Resume Preparation:</strong> Use LPU’s resume-building services.</li><br>
                <li><strong>Mock Interviews:</strong> Participate in mock interviews to boost confidence.</li><br>
                <li><strong>Company-Specific Preparation:</strong> Attend training sessions for specific companies.</li><br>
                <li><strong>Career Counseling:</strong> Consult with placement counselors for guidance.</li><br>
                <li><strong>Placement Drive Updates:</strong> Check UMS regularly for drive announcements.</li><br>
            </ul>
        </div>
    </div>
</section>
<section class="placement-overview">
        <h2>Placement Overview</h2>
        <div class="stats">
            <div class="stat-box">
                <h3>2024</h3>
                <p><strong>Total Companies:</strong> 150+</p>
                <p><strong>Students Placed:</strong> 1200+</p>
                <p><strong>Highest Package:</strong> ₹42 LPA</p>
            </div>
            <div class="stat-box">
                <h3>2025</h3>
                <p><strong>Total Companies:</strong> 170+</p>
                <p><strong>Students Placed:</strong> 1400+</p>
                <p><strong>Highest Package:</strong> ₹48 LPA</p>
            </div>
        </div>
    </section>
<!-- Placement Stats Section -->
<section class="placement-overview">
    <h2>Company-Wise Placement Details</h2>
    <table border="1">
        <tr>
            <th>Year</th>
            <th>Company</th>
            <th>Role</th>
            <th>Job Profile</th>
        </tr>

        <?php
        // Fetching from the correct column
        $sql = "SELECT year, company, role, job_profile FROM company_info ORDER BY year DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['year']) . "</td>
                    <td>" . htmlspecialchars($row['company']) . "</td>
                    <td>" . htmlspecialchars($row['role']) . "</td>";

                // Display the job profile link only if the file exists
                if (!empty($row['job_profile'])) {
                    echo "<td>
                        <a href='view_pdf.php?path=" . urlencode($row['job_profile']) . "' target='_blank' class='job-profile-btn'>
                            View Job Profile
                        </a>
                    </td>";
                } else {
                    echo "<td>N/A</td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data available</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</section>

<footer>
    <p>&copy; 2025 Roadmap for BCA | Lovely Professional University</p>
</footer>

</body>
</html>
