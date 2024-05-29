<?php
    session_start();
    require_once '../include/connect.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);
    // Переменная для хранения символов
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    // Получаем длину строки
    $numChars = strlen($chars);
    // Переменная для пароля
    $pass = '';
    // Цикл для создания пароля
    for ($i = 0; $i < 8; $i++  ) {
        $pass .= substr($chars, rand(1, $numChars) - 1, 1);
    }

    $email = $_POST['email'];

    // Переменная $headers нужна для Email заголовка
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "To: <$email>\r\n";
    $headers .= "From: <admin@coderum.ru>\r\n";
    // Сообщение для Email
    $message = '
        <html>
        <head>
        <title>Восстановление пароля</title>
        </head>
        <body>
        <p>Ваш новый пароль: ' . $pass . '</p>
        </body>
        </html>
    ';


    $pass = md5($pass);

    mysqli_query($connect, "UPDATE `user` SET `PASSWORD` = '$pass' WHERE `EMAIL` = '$email'");

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.hosting.reg.ru';
        $mail->SMTPAuth   = true;
        $mail->Username   = '';
        $mail->Password   = '';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'CodeRum - восстановление пароля';
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Не получается отправить сообщение, ошибка: {$mail->ErrorInfo}. Сообщение: {$message}";
    }

?>
