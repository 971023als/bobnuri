<?php
/**
 * Security Configuration for Mock Hacking Site
 * Levels: 1 (Beginner) to 5 (Secure)
 */

// Simple .env loader for non-docker environments (like XAMPP)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . "=" . trim($value));
    }
}

// Default to Level 1 if not set
session_start();
if (isset($_SESSION['security_level'])) {
    $security_level = $_SESSION['security_level'];
} else {
    $security_level = getenv('SECURITY_LEVEL') ?: '1';
}

function get_security_level() {
    global $security_level;
    return (int)$security_level;
}

/**
 * Level 1: Beginner - Total vulnerability (Raw SQL, Plaintext Passwords)
 */
function is_level1() { return get_security_level() <= 1; }

/**
 * Level 2: Easy - Basic filtering (real_escape_string), Plaintext Passwords
 */
function is_level2() { return get_security_level() == 2; }

/**
 * Level 3: Medium - Basic filtering, Weak Hashing (MD5)
 */
function is_level3() { return get_security_level() == 3; }

/**
 * Level 4: Hard - Prepared Statements, Strong Hashing (Bcrypt)
 */
function is_level4() { return get_security_level() == 4; }

/**
 * Level 5: Secure - Prepared Statements, Bcrypt, XSS Protection (HTML Escaping)
 */
function is_level5() { return get_security_level() >= 5; }

// Helper for XSS protection
function xss_check($str) {
    if (is_level5()) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    return $str;
}
?>
