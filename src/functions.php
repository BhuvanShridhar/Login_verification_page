<?php

function generateVerificationCode(): string {
    return strval(rand(100000, 999999));
}

function sendVerificationEmail(string $email, string $code): bool {
    $subject = "Your Verification Code";
    $message = "<p>Your verification code is: <strong>$code</strong></p>";
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-Type: text/html\r\n";
    return mail($email, $subject, $message, $headers);
}

function registerEmail(string $email): bool {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

    if (!in_array($email, $emails)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
        return true;
    }
    return false;
}

function unsubscribeEmail(string $email): bool {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return false;

    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $updated = array_filter($emails, fn($e) => trim($e) !== trim($email));
    file_put_contents($file, implode(PHP_EOL, $updated) . PHP_EOL);
    return true;
}

function fetchGitHubTimeline() {
    // Sample static data since https://github.com/timeline doesn't exist
    return [
        ['event' => 'Push', 'user' => 'testuser'],
        ['event' => 'Fork', 'user' => 'anotheruser']
    ];
}

function formatGitHubData(array $data): string {
    $html = "<h2>GitHub Timeline Updates</h2>";
    $html .= "<table border='1'><tr><th>Event</th><th>User</th></tr>";
    foreach ($data as $entry) {
        $html .= "<tr><td>" . htmlspecialchars($entry['event']) . "</td><td>" . htmlspecialchars($entry['user']) . "</td></tr>";
    }
    $html .= "</table>";
    return $html;
}

function sendGitHubUpdatesToSubscribers(): void {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return;

    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (empty($emails)) return;

    $data = fetchGitHubTimeline();
    $html = formatGitHubData($data);

    foreach ($emails as $email) {
        $unsubscribeUrl = "http://localhost/GH-timeline/src/unsubscribe.php?email=" . urlencode($email);
        $message = $html . "<p><a href=\"$unsubscribeUrl\" id=\"unsubscribe-button\">Unsubscribe</a></p>";
        $subject = "Latest GitHub Updates";
        $headers = "From: no-reply@example.com\r\nContent-Type: text/html\r\n";
        mail($email, $subject, $message, $headers);
    }
}
