<?php
require_once '../Init.php';

$user = new User();

$raw = $_POST['data'];
$encoded = base64_encode($raw);

$update = DB::getInstance()->update('template', 1, array(
    '`template_ID`' => $encoded
));
?>