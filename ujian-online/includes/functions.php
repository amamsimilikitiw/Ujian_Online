<?php
// includes/functions.php

// Set zona waktu ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function base_url(string $path = ''): string {
    return '/ujian-online/' . ltrim($path, '/');
}

function set_flash($key, $message, $type = 'success') {
    $_SESSION['flash'][$key] = ['message' => $message, 'type' => $type];
}

function get_flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $flash = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash;
    }
    return null;
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . base_url('auth/login.php'));
        exit;
    }
}

function is_role($role): bool {
    return is_logged_in() && $_SESSION['user']['role'] === $role;
}

function require_role($roles = []) {
    require_login();
    if (!in_array($_SESSION['user']['role'], (array)$roles)) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>Anda tidak memiliki akses.";
        exit;
    }
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
