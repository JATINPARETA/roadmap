<?php
// Get the PDF path from the URL parameter
if (isset($_GET['path'])) {
    $file_path = $_GET['path'];

    // Validate the file path to prevent malicious access
    $safe_path = htmlspecialchars($file_path);
} else {
    echo "No file specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Profile - View Only</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            overflow: hidden;  /* Prevent scrolling */
        }
        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Render the PDF as an image */
        .pdf-view {
            max-width: 90%;
            max-height: 90%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            pointer-events: none; /* Prevent interaction */
        }
        /* Transparent overlay to prevent screenshots */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0);
            z-index: 9999;
            pointer-events: none;  /* Prevent interaction */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="overlay"></div>

    <!-- Display PDF as an image -->
    <embed src="<?php echo $safe_path; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf"
           class="pdf-view" width="90%" height="90%">
</div>

<script>
    // Disable right-click
    document.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        alert('Right-click is disabled!');
    });

    // Disable Ctrl+S, Ctrl+P, Ctrl+Shift+I, F12, PrintScreen, and other shortcuts
    document.addEventListener('keydown', (e) => {
        if (
            e.key === "F12" ||                 // F12 (Dev tools)
            (e.ctrlKey && e.shiftKey && e.key === "I") ||   // Ctrl + Shift + I (Inspect)
            (e.ctrlKey && e.shiftKey && e.key === "J") ||   // Ctrl + Shift + J (Console)
            (e.ctrlKey && e.key === "S") ||   // Ctrl + S (Save as)
            (e.ctrlKey && e.key === "P") ||   // Ctrl + P (Print)
            (e.metaKey && e.key === "p") ||   // Cmd + P (Print on Mac)
            (e.key === "PrintScreen")          // PrintScreen (Screenshot)
        ) {
            e.preventDefault();
            alert('Saving, printing, and screenshots are disabled!');
        }
    });

    // Disable PrintScreen (PrtSc) by clearing the clipboard
    document.addEventListener('keyup', (e) => {
        if (e.key === 'PrintScreen') {
            alert('Screenshots are disabled!');
            navigator.clipboard.writeText('');
        }
    });

    // Detect and block Developer Tools
    (function() {
        const devtools = { open: false };
        const threshold = 160;

        const check = () => {
            const widthThreshold = window.outerWidth - window.innerWidth > threshold;
            const heightThreshold = window.outerHeight - window.innerHeight > threshold;
            devtools.open = widthThreshold || heightThreshold;

            if (devtools.open) {
                alert("Developer tools are disabled!");
                window.location.reload();
            }
        };

        setInterval(check, 1000);
    })();
</script>

</body>
</html>
