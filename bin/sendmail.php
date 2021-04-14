<?php

// $to      = 'pcummerata@gravitio.info';
$to      = 'till20052@gmail.com';
$subject = 'the subject';
$message = 'hello';

if (!mail($to, $subject, $message, implode(PHP_EOL, [
    'From: info@models.org.ua',
    'Reply-To: info@models.org.ua',
    sprintf('X-Mailer: PHP/%s', PHP_VERSION),
]))) {
    return printf('Error' . PHP_EOL);
}

printf('Ok' . PHP_EOL);
