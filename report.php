<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        label { display: inline-block; width: 100px; }
        input[type="date"] { padding: 5px; margin-bottom: 10px; }
        input[type="submit"],[type="button"] {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"],[type="button"]:hover { background-color: #45a049; }
        table {width: 100%;border-collapse: collapse;margin-top: 20px;background-color: #ffffff;}
        th, td {padding: 10px 12px;text-align: center;border: 1px solid #ddd;}
        th {background-color: #4CAF50;color: white;}
        tr:nth-child(even) {background-color: #f2f2f2;}
        tr:hover {background-color: #e6f7ff;}
        h2 {margin-top: 30px;}
    </style>
</head>
<body>

<h2>Generate Feedback Report</h2>

<form method="post">
    <label>From Date:</label>
    <input type="date" name="from_date" required><br><br>

    <label>To Date:</label>
    <input type="date" name="to_date" required><br><br>

    <input type="submit" name="submit" value="Generate Report">
    <input type="button" name="back" value="Back To Home" onclick="window.location.href='index.html'">    
</form>



<?php
if (isset($_POST['submit'])) {

    require __DIR__ . '/includes/functions.php';
    $conn = db();

    $from = $_POST['from_date'];
    $to   = $_POST['to_date'];
    if($to < $from){
        echo "<h2>Invalid date range. 'To Date' must be after 'From Date'.</h2>";
        exit();
    }
    else if($from > date("Y-m-d") || $to > date("Y-m-d")){
        echo "<h2>Invalid date range. Dates cannot be in the future.</h2>";
        exit();
    }    
    $stmt = $conn->prepare("SELECT * FROM Feedback WHERE Feedback_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<h2>No feedbacks found between " . e($from) . " and " . e($to) . "</h2>";
        exit();
    }
    else{
        echo "<h2>Feedbacks between " . e($from) . " and " . e($to) . "</h2>";

        // Export CSV (public page). For a more secure version, use admin dashboard.
        echo "<p><a href='export_csv.php?from=" . e($from) . "&to=" . e($to) . "'>Export CSV</a></p>";

    echo "<table border='1' cellpadding='8'>
            <tr>                
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Promotion</th>
                <th>SMS</th>
                <th>WhatsApp</th>
                <th>Email</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . e((string)$row['Name']) . "</td>
                <td>" . e((string)$row['Emailid']) . "</td>
                <td>" . e((string)$row['Phone']) . "</td>
                <td>" . e((string)$row['Promotion']) . "</td>
                <td>" . e((string)$row['Channel_S']) . "</td>
                <td>" . e((string)$row['Channel_W']) . "</td>
                <td>" . e((string)$row['Channel_M']) . "</td>
              </tr>";
    }

    echo "</table>";
    }
    

    $stmt->close();
    // Connection is shared; no need to close.
    
}
?>

</body>
</html>
