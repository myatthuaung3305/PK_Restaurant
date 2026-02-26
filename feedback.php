<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

// Basic hardening
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.html');
  exit;
}

csrf_verify($_POST['csrf_token'] ?? null);

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$phone = normalize_phone((string)($_POST['phone'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));
$promotion = (string)($_POST['promotion'] ?? '');

$sms = isset($_POST['sms']) ? 'Y' : 'N';
$whatsapp = isset($_POST['whatsapp']) ? 'Y' : 'N';
$emailch = isset($_POST['emailch']) ? 'Y' : 'N';

// Validation (simple but real-world)
$errors = [];
if ($name === '' || mb_strlen($name) < 2 || mb_strlen($name) > 80) $errors[] = 'Name must be 2–80 characters.';
if (!is_valid_email($email)) $errors[] = 'Please enter a valid email.';
if ($phone === '' || strlen($phone) < 8 || strlen($phone) > 15) $errors[] = 'Phone number looks invalid.';
if ($message === '' || mb_strlen($message) < 5 || mb_strlen($message) > 1000) $errors[] = 'Feedback must be 5–1000 characters.';
if (!in_array($promotion, ['Y', 'N'], true)) $errors[] = 'Promotion value is invalid.';

if ($promotion === 'N') {
  // If user says no promotion, channels should be N
  $sms = $whatsapp = $emailch = 'N';
}

if ($errors) {
  $msg = implode('\n', array_map('e', $errors));
  echo "<script>alert('" . $msg . "'); window.location.href='index.html#Contactus';</script>";
  exit;
}

$date = date('Y-m-d');

$conn = db();
$stmt = $conn->prepare(
  'INSERT INTO Feedback (Feedback_date, Name, Emailid, Phone, Feedback, Promotion, Channel_S, Channel_W, Channel_M)\n'
  . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)' 
);
if (!$stmt) {
  http_response_code(500);
  die('Failed to prepare statement.');
}

$stmt->bind_param('sssssssss', $date, $name, $email, $phone, $message, $promotion, $sms, $whatsapp, $emailch);
$stmt->execute();
$stmt->close();

echo "<script>
  alert('Feedback Saved Successfully! Thank You For Your Feedback!');
  window.location.href = 'index.html';
</script>";
