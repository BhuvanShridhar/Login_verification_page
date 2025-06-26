<?php
session_start();
require_once 'functions.php';

$message = '';
$error = '';

// Handle email submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit-email'])) {
    $email = trim($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $code = generateVerificationCode();
        $_SESSION['email'] = $email;
        $_SESSION['verification_code'] = $code;

        if (sendVerificationEmail($email, $code)) {
            $message = "✅ Verification code sent to <strong>$email</strong>.";
        } else {
            $error = "❌ Failed to send verification email.";
        }
    } else {
        $error = "❌ Invalid email format.";
    }
}

// Handle verification code submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit-verification'])) {
    $inputCode = trim($_POST['verification_code']);

    if (isset($_SESSION['verification_code']) && $inputCode === $_SESSION['verification_code']) {
        if (registerEmail($_SESSION['email'])) {
            $message = "✅ Email <strong>{$_SESSION['email']}</strong> verified and registered successfully.";
        } else {
            $message = "ℹ️ Email is already registered.";
        }

        unset($_SESSION['email']);
        unset($_SESSION['verification_code']);
    } else {
        $error = "❌ Invalid verification code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GitHub Timeline Subscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #222;
        }

        form {
            background: #fff;
            padding: 20px 30px;
            margin: 20px auto;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 10px 20px;
            background: #4CAF50;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }

        p {
            text-align: center;
            font-weight: bold;
        }

        hr {
            max-width: 400px;
            margin: 30px auto;
            border: none;
            border-top: 1px solid #ccc;
        }

        .message {
            text-align: center;
            font-size: 1rem;
            margin-top: 10px;
        }

        .message strong {
            color: #4CAF50;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>📧 Subscribe to GitHub Timeline Updates</h1>

    <?php if ($message): ?>
        <p class="message success"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="message error"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Email Submission Form -->
    <form method="POST">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="submit-email" id="submit-email">Submit</button>
    </form>

    <!-- Verification Code Form -->
    <form method="POST">
        <label for="verification_code">Enter 6-digit verification code:</label>
        <input type="text" name="verification_code" maxlength="6" required>
        <button type="submit" name="submit-verification" id="submit-verification">Verify</button>
    </form>
</body>
</html>
