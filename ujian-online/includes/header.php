<?php // includes/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($title) ? h($title) . ' - ' : '' ?>Aplikasi Ujian Online</title>
<link rel="stylesheet" href="/ujian-online/assets/css/style.css">

</head>
<body>