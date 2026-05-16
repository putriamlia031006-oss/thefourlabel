<?php
if (isset($_POST['submit'])) {
    $to = "1224160102@global.ac.id";
    
    // Membersihkan input dari karakter berbahaya
    $name    = strip_tags(trim($_POST['name']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject_input = strip_tags(trim($_POST['subject']));
    $message_input = strip_tags(trim($_POST['message']));

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
        exit;
    }

    $subject = "Pesan Baru dari Website: " . $subject_input;
    $body    = "Nama: $name\nEmail: $email\n\nPesan:\n$message_input";
    
    // Header tambahan untuk meningkatkan kemungkinan email diterima
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Pesan Berhasil Terkirim!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pesan. Pastikan mail server aktif.'); window.history.back();</script>";
    }
}
?>
