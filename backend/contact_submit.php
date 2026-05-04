<?php
session_start();
require_once __DIR__ . '/csrf.php';

$token = $_POST['csrf_token'] ?? '';
if (!validateCsrfToken($token)) {
    echo json_encode(['success' => false, 'msg' => 'CSRF token tidak valid']);
    exit;
}
// backend/contact_submit.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

// Ambil data dari form
$name       = trim($_POST['name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$category   = trim($_POST['category'] ?? '');
$message    = trim($_POST['message'] ?? '');
$newsletter = isset($_POST['newsletter']) ? 1 : 0;

$errors = [];
if ($name === '' || mb_strlen($name) < 3) $errors[] = 'Nama minimal 3 karakter';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid';
if ($category === '') $errors[] = 'Kategori harus dipilih';
if ($message === '' || mb_strlen($message) < 10) $errors[] = 'Pesan minimal 10 karakter';

if ($errors) {
    echo json_encode(['success' => false, 'msg' => implode('; ', $errors)]);
    exit;
}

// Simpan ke database
$stmt = $mysqli->prepare(
    "INSERT INTO contacts (name, email, phone, category, message, newsletter) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('sssssi', $name, $email, $phone, $category, $message, $newsletter);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'msg' => "Terima kasih $name! Pesan Anda telah terkirim."]);
} else {
    echo json_encode(['success' => false, 'msg' => 'Gagal menyimpan data']);
}

$stmt->close();
$mysqli->close();