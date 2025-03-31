<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marking Scheme - Roadmap for BCA</title>
    <link rel="stylesheet" href="marking.css">
</head>
<body>

    <header>
        <h1>Marking Scheme - Roadmap for BCA</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="placement.php">Placement Stats</a></li>
                <li><a href="cgpa.php">CGPA Calculator</a></li>
            </ul>
        </nav>
    </header>

    <section class="marking-details">
        <h2>Marking Scheme</h2>
        <table>
            <tr>
                <th>Component</th>
                <th>Details</th>
                <th>Marks</th>
            </tr>
            <tr>
                <td>Continuous Assessment (CA)</td>
                <td>3 CAs (Each of 30 Marks)</td>
                <td>90</td>
            </tr>
            <tr>
                <td>Mid-Term Exam (MTE)</td>
                <td>80% MCQ + 20% Theory</td>
                <td>50</td>
            </tr>
            <tr>
                <td>End-Term Theory (ETE)</td>
                <td>Final Exam - Subjective</td>
                <td>50</td>
            </tr>
            <tr>
                <td>End-Term Practical (ETP)</td>
                <td>Lab Exams / Viva</td>
                <td>50</td>
            </tr>
        </table>
    </section>

    <section class="calculator">
        <h2>Mark Calculator</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <th>Component</th>
                    <th>Max Marks</th>
                    <th>Enter Your Marks</th>
                </tr>
                <tr>
                    <td>Continuous Assessment (CA)</td>
                    <td>90</td>
                    <td><input type="number" name="ca" placeholder="Enter CA Marks" required></td>
                </tr>
                <tr>
                    <td>Mid-Term Exam (MTE)</td>
                    <td>50</td>
                    <td><input type="number" name="mte" placeholder="Enter MTE Marks" required></td>
                </tr>
                <tr>
                    <td>End-Term Theory (ETE)</td>
                    <td>50</td>
                    <td><input type="number" name="ete" placeholder="Enter ETE Marks" required></td>
                </tr>
                <tr>
                    <td>End-Term Practical (ETP)</td>
                    <td>50</td>
                    <td><input type="number" name="etp" placeholder="Enter ETP Marks" required></td>
                </tr>
            </table>
            <button type="submit" name="calculate">Calculate</button>
        </form>

        <?php
        if (isset($_POST['calculate'])) {
            $ca = isset($_POST['ca']) ? floatval($_POST['ca']) : 0;
            $mte = isset($_POST['mte']) ? floatval($_POST['mte']) : 0;
            $ete = isset($_POST['ete']) ? floatval($_POST['ete']) : 0;
            $etp = isset($_POST['etp']) ? floatval($_POST['etp']) : 0;

            $totalMarks = $ca + $mte + $ete + $etp;
            $percentage = ($totalMarks / 240) * 100;
            
            $passing = ($ete >= 15 || $etp >= 15) && ($mte + $ete + $etp) >= 15 && $percentage >= 40;

            echo "<h3><strong>Total Marks: $totalMarks / 240</strong></h3>";
            echo "<h3>Percentage: " . number_format($percentage, 2) . "%</h3>";

            if ($passing) {
                echo "<h3 style='color: green;'>You have passed.</h3>";
            } else {
                echo "<h3 style='color: red;'>You failed.</h3>";
            }
        }
        ?>
    </section>

</body>
</html>
