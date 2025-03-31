<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGPA Calculator - Roadmap for BCA</title>
    <link rel="stylesheet" href="cgpasemester1.css">
</head>
<body>

    <header>
        <h1>CGPA Calculator</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="marking.php">Marking Scheme</a></li>
                <li><a href="placement.php">Placement</a></li>
            </ul>
        </nav>
    </header>

    <section class="calculator">
        <h2>Enter Your Marks</h2>
        <form method="POST">
            <?php 
            // Define subjects and their respective categories with maximum marks
            $subjects = [
                "FUNDAMENTALS OF INFORMATION TECHNOLOGY" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Objective Type End Term" => 30,
                    "Objective Type Mid Term" => 30, "Theory End Term" => 40
                ],
                "FUNDAMENTALS OF INFORMATION TECHNOLOGY-LABORATORY" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Practical End Term" => 100
                ],
                "PROGRAMMING METHODOLOGIES" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Objective Type End Term" => 30,
                    "Objective Type Mid Term" => 30, "Theory End Term" => 40
                ],
                "PROGRAMMING METHODOLOGIES-LABORATORY" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Practical End Term" => 100
                ],
                "ENVIRONMENTAL STUDIES" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Objective Type End Term" => 60,
                    "Objective Type Mid Term" => 30
                ],
                "DISCRETE STRUCTURES" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Objective Type End Term" => 30,
                    "Objective Type Mid Term" => 30, "Theory End Term" => 40
                ],
                "ENGLISH COMMUNICATION SKILLS" => [
                    "Attendance" => 5, "Continuous Assessment" => 100, "Objective Type End Term" => 30,
                    "Objective Type Mid Term" => 30, "Theory End Term" => 40
                ]
            ];

            foreach ($subjects as $subject => $categories) {
                echo "<h3>$subject</h3>";
                echo "<table><tr><th>Category</th><th>Maximum Marks</th><th>Marks Obtained</th></tr>";

                foreach ($categories as $category => $max_marks) {
                    echo "<tr>
                            <td>$category</td>
                            <td>$max_marks</td>
                            <td><input type='number' name='".str_replace(' ', '_', $subject."_".$category)."' min='0' max='$max_marks' required></td>
                          </tr>";
                }
                echo "</table>";
            }
            ?>
            <button type="submit" name="calculate">Calculate CGPA</button>
        </form>

        <?php
        if (isset($_POST['calculate'])) {
            // Predefined weightages
            $weightages = [
                "Attendance" => 5,
                "Continuous Assessment" => 25,
                "Objective Type End Term" => 15,
                "Objective Type Mid Term" => 20,
                "Theory End Term" => 35,
                "Practical End Term" => 50
            ];

            $total_weighted_marks = 0;
            $total_weightage = 0;

            foreach ($subjects as $subject => $categories) {
                $subject_total = 0;
                $subject_max = 0;
                
                foreach ($categories as $category => $max_marks) {
                    $field_name = str_replace(' ', '_', $subject."_".$category);
                    $obtained_marks = $_POST[$field_name];

                    $weightage = $weightages[$category] ?? 0;
                    $subject_total += ($obtained_marks / $max_marks) * $weightage;
                    $subject_max += $weightage;
                }

                $total_weighted_marks += $subject_total;
                $total_weightage += $subject_max;
            }

            // Final percentage and CGPA calculation
            $final_percentage = ($total_weighted_marks / $total_weightage) * 100;
            $cgpa = $final_percentage / 10;

            echo "<div class='result'>";
            echo "<h3>CGPA: " . round($cgpa, 2) . " / 10</h3>";

            if ($final_percentage >= 40) {
                echo "<p class='pass'>Status: Pass ✅</p>";
            } else {
                echo "<p class='fail'>Status: Fail ❌</p>";
            }
            echo "</div>";
        }
        ?>
    </section>

    

</body>
</html>
