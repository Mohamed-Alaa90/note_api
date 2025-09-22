<?php


$stmt = $con->prepare("UPDATE `users` SET `username`='gamal',`email`='gamal@gmail.com' WHERE 1");

$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
    echo 'create success';
} else {
    echo 'filer';
}