<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';
?>
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
        input[type="submit"], input[type="button"] {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="button"]:hover { background-color: #45a049; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #ffffff; }
        th, td { padding: 10px 12px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #e6f7ff; }
        h2 { margin-top: 30px; }
    </style>
</head>
<body>

<h2>Generate Feedback Report</h2>

<form method="post">
    <label for="from_date">From Date:</label>
    <input type="date" id="from_date" name="from_date" required><br><br>

    <label for="to_date">To Date:</label>
    <input type="date" id="to_date" name="to_date" required><br><br>

    <input type="submit" name="submit" value="Generate Report">
    <input type="button" value="Back To Home" onclick="window.location.href='index.html'">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db();

    $from = trim((string)($_POST['from_date'] ?? ''));
    $to = trim((string)($_POST['to_date'] ?? ''));

    if (!is_valid_iso_date($from) || !is_valid_iso_date($to)) {
        echo '<h2>Invalid date format. Please use YYYY-MM-DD.</h2>';
        exit;
    }

    $today = date('Y-m-d');
    if ($to < $from) {
        echo "<h2>Invalid date range. 'To Date' must be after 'From Date'.</h2>";
        exit;
    }

    if ($from > $today || $to > $today) {
        echo '<h2>Invalid date range. Dates cannot be in the future.</h2>';
        exit;
    }

    $stmt = $conn->prepare('SELECT Name, Emailid, Phone, Promotion, Channel_S, Channel_W, Channel_M FROM Feedback WHERE Feedback_date BETWEEN ? AND ?');
    if (!$stmt) {
        http_response_code(500);
        die('Failed to prepare report query.');
    }

    $stmt->bind_param('ss', $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo '<h2>No feedback found between ' . e($from) . ' and ' . e($to) . '.</h2>';
        $stmt->close();
        exit;
    }

    echo '<h2>Feedback between ' . e($from) . ' and ' . e($to) . '</h2>';
    echo '<p><a href="export_csv.php?from=' . urlencode($from) . '&to=' . urlencode($to) . '">Export CSV</a></p>';

    echo "<table>
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
        echo '<tr>'
            . '<td>' . e((string)$row['Name']) . '</td>'
            . '<td>' . e((string)$row['Emailid']) . '</td>'
            . '<td>' . e((string)$row['Phone']) . '</td>'
            . '<td>' . e((string)$row['Promotion']) . '</td>'
            . '<td>' . e((string)$row['Channel_S']) . '</td>'
            . '<td>' . e((string)$row['Channel_W']) . '</td>'
            . '<td>' . e((string)$row['Channel_M']) . '</td>'
            . '</tr>';
    }

    echo '</table>';
    $stmt->close();
}
?>

</body>
</html>
