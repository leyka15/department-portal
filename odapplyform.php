<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OD Application Form</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="sidebar">
        <div>
            <ul>
                <li>
                    <div class="logo-text-container">
                        <img src="images/rmkcet1.png" alt="" class="imh">
                    </div>
                </li>
                <li>
                    <div class="logo-text-container">
                        <img src="images/homelogo1.png" alt="" class="imh">
                        <a href="web.php" class="logo-text">Home</a>
                    </div>
                </li>
                <li>
                    <div class="logo-text-container">
                        <img src="images/back.png" alt="" class="imh">
                        <a href="studentwelcomepage.php" class="logo-text">Back</a>
                    </div>
                </li>
                <li>
                    <div class="logo-text-container">
                        <img src="images/logout1.png" alt="" class="imh">
                        <a href="admin.php" class="logo-text">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <h1>OD Application Form</h1>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="regno">Register Number:</label>
                <input type="text" id="regno" name="regno" required>
            </div>
            <div class="form-group">
                <label for="email">Email id:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="sem">Semester:</label>
                <input type="text" id="sem" name="sem" required>
            </div>
            <div class="form-group">
                <label for="startdate">Start Date:</label>
                <input type="date" id="startdate" name="startdate" required>
            </div>
            <div class="form-group">
                <label for="enddate">End Date:</label>
                <input type="date" id="enddate" name="enddate">
            </div>
            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea id="reason" name="reason" rows="4" required></textarea>
            </div>
            <!-- PHP code starts here -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Database connection
                $conn = mysqli_connect('localhost', 'root', 'root', 'students');
                
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Get form data and sanitize it
                $name = $_POST['name'];
                $regno = $_POST['regno'];
                $email = $_POST['email'];
                $sem = $_POST['sem'];
                $startdate = $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $reason = $_POST['reason'];

                // Prepare SQL statement
                $sql = "INSERT INTO odapply (name, regno, email, sem, startdate, enddate, reason) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                // Create prepared statement
                $stmt = mysqli_prepare($conn, $sql);
                
                // Bind parameters to placeholders
                mysqli_stmt_bind_param($stmt, "sssssss", $name, $regno,$email, $sem, $startdate, $enddate, $reason);
                
                // Execute statement
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "OD is applied";
                } else {
                    $error_message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

                // Close statement
                mysqli_stmt_close($stmt);
                
                // Close connection
                mysqli_close($conn);
            }
            ?>
            <!-- PHP code ends here -->
            <input type="submit" value="Submit">
            <input type="button" value="View Status" onclick="window.location.href='odapplyviewstatus.php';">
        </form>
    </div>
    <div class="center">
        <?php if (isset($success_message)) : ?>
        <p><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>