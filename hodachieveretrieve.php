<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hod Achievements</title>
<link rel="stylesheet" href="stuachieveretrieve.css">
<style>
    h1 {
        text-align: center;
    }
    .form-container {
        width: 70%;
        margin: 0 auto;
        height: 90%;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        color: white;
        font-weight: bold;
        margin-left: 95px;
    }
    .form-group input[type="text"] {
        width: 310px;
        padding: 10px;
        box-sizing: border-box;
        margin-left: 110px;
        border-radius: 20px:
    }
</style>
</head>
<body>
<h1>Hod Activities</h1>
<div class="sidebar"> 
        <div>
            <ul>
                <li>
                    <div class="logo-text-container">
                        <img src="images/rmkcet1.png" alt="" class="imh1">
                        
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
                        <a href="hodwelcome.php" class="logo-text">Back</a>
                    </div>
                </li>
                <li>
                    <div class="logo-text-container">
                        <img src="images/logout1.png" alt="" class="imh">
                        <a href="hodlogin.php" class="logo-text">Logout</a>
                    </div>
                </li>
            </ul>    
        </div>
    </div>
<div class="container">
<?php
session_start();

// Check if session user is set
if(isset($_SESSION['sess_user'])) {
    $sessionUser = $_SESSION['sess_user'];
} else {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "hod";

// Create connection
$_con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($_con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// SQL query to retrieve data
$query = "SELECT first_name,last_name,reg_no,dept, journalpaper, conferencepaper, awards,coursesandcertification FROM `hodachievements` WHERE first_name = '$sessionUser'";

// Execute query
$result = mysqli_query($_con, $query);

// Check if query executed successfully
if ($result) {
    // Check if there are any rows returned
    if(mysqli_num_rows($result) > 0) {
        
        $row = mysqli_fetch_assoc($result);

            $labels = array(
                'first_name' => 'First Name','last_name' => 'Last Name','reg_no' => 'Faculty Id','dept'=>'Department',
                'journalpaper' => 'Journal Paper','conferencepaper' => 'Conference Paper',
                'awards' => 'Awards Recieved','coursesandcertification' => 'Courses and Certifications'
                // Add more custom labels for other columns as needed
            );
    
            // Output form fields for each column
            foreach ($row as $key => $value) {
                echo '<div class="form-group">';
                echo "<label for='$key'>" . ($labels[$key] ?? $key) . ":</label>"; // Use custom label if available, otherwise use column name
                echo "<input type='text' id='$key' name='$key' value='$value' readonly>";
                echo '</div>';
            }

    } else {
        echo "No data found!";
    }
} else {
    echo "Error: " . mysqli_error($_con);
}

// Close database connection
mysqli_close($_con);
?>
</div>

</body>
</html>

