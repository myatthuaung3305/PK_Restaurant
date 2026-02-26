<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

$from = trim((string)($_GET['from'] ?? ''));
$to = trim((string)($_GET['to'] ?? ''));

if (!is_valid_iso_date($from) || !is_valid_iso_date($to)) {
    http_response_code(400);
    die('Invalid date format.');
}

$today = date('Y-m-d');
if ($to < $from || $from > $today || $to > $today) {
    http_response_code(400);
    die('Invalid date range.');
}

$conn = db();
$stmt = $conn->prepare('SELECT Feedback_date, Name, Emailid, Phone, Promotion, Channel_S, Channel_W, Channel_M, Feedback FROM Feedback WHERE Feedback_date BETWEEN ? AND ? ORDER BY Feedback_date DESC');
if (!$stmt) {
    http_response_code(500);
    die('Failed to prepare export query.');
}

$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$res = $stmt->get_result();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="pandan_feedback_' . $from . '_to_' . $to . '.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['date', 'name', 'email', 'phone', 'promotion', 'sms', 'whatsapp', 'email_channel', 'feedback']);
while ($row = $res->fetch_assoc()) {
    fputcsv($out, [
        csv_safe_cell((string)$row['Feedback_date']),
        csv_safe_cell((string)$row['Name']),
        csv_safe_cell((string)$row['Emailid']),
        csv_safe_cell((string)$row['Phone']),
        csv_safe_cell((string)$row['Promotion']),
        csv_safe_cell((string)$row['Channel_S']),
        csv_safe_cell((string)$row['Channel_W']),
        csv_safe_cell((string)$row['Channel_M']),
        csv_safe_cell((string)$row['Feedback']),
    ]);
}
fclose($out);

$stmt->close();
