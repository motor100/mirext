<?php

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["name"]) &&
   isset($_POST["phone"]) && 
   isset($_POST["category"]) && 
   isset($_POST["checkbox-privacy-policy"]) && 
   isset($_POST["checkbox-private-data"])) {

    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $category = htmlspecialchars($_POST["category"]);
    $checkbox_privacy_policy = $_POST["checkbox-privacy-policy"];
    $checkbox_private_data = $_POST["checkbox-private-data"];

    require 'PHPMailer.php';
    require 'SMTP.php';
    require 'config.php';

    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';

    // Настройки SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;

    $mail->Host = $Host;
    $mail->Username = $Username; // Для Яндекс почты должно быть одинаковым
    $mail->Password = $Password;

    $mail->Port = 465;

    // От кого
    $mail->From = $Username; // Для Яндекс почты должно быть одинаковым
    $mail->FromName = $Username; // Для Яндекс почты должно быть одинаковым

    // Кому
    $mail->addAddress($To);

    if ($cc) {
      $mail->addCC($cc);
    }

    // Тема письма
    $mail->Subject = 'Сообщение с сайта biosalts.ru';

    $mail->isHTML(true);

    if (strlen($name) >= 3 &&
      strlen($name) <= 50 &&
      strlen($phone) == 18 && 
      strlen($category) >= 3 &&
      strlen($category) <= 100 &&
      $checkbox_privacy_policy == "on" && 
      $checkbox_private_data == "on") {

        // Тело письма
        $mail->Body = "Имя: $name<br> Телефон: $phone<br> Категория: $category<br>";
        $mail->AltBody = "Имя: $name\r\n Телефон: $phone\r\n Категория: $category\r\n";

        $mail->send();
    }

    $mail->smtpClose();

} else {
    header("Location: /");
    exit;
}

?>