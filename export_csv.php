<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

$from = (string)($_GET['from'] ?? '');
$to = (string)($_GET['to'] ?? '');

if (!$from || !$to) {
  http_response_code(400);
  die('Missing date range.');
}
if ($to < $from) {
  http_response_code(400);
  die('Invalid date range.');
}

$conn = db();
$stmt = $conn->prepare('SELECT Feedback_date, Name, Emailid, Phone, Promotion, Channel_S, Channel_W, Channel_M, Feedback FROM Feedback WHERE Feedback_date BETWEEN ? AND ? ORDER BY Feedback_date DESC');
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$res = $stmt->get_result();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="pandan_feedback_' . $from . '_to_' . $to . '.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['date','name','email','phone','promotion','sms','whatsapp','email_channel','feedback']);
while ($row = $res->fetch_assoc()) {
  fputcsv($out, [
    $row['Feedback_date'],
    $row['Name'],
    $row['Emailid'],
    $row['Phone'],
    $row['Promotion'],
    $row['Channel_S'],
    $row['Channel_W'],
    $row['Channel_M'],
    $row['Feedback'],
  ]);
}
fclose($out);

$stmt->close();
