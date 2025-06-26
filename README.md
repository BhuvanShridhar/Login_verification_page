# Login_verification_page
Tech Stack: PHP, Mailpit, CRON, HTML, CSS, Bash, XAMPP (Apache + PHP 8.3)

📌 Project Description:
Developed a secure PHP-based email verification and notification system that allows users to subscribe to GitHub timeline updates. Users register via email, verify using a 6-digit code, and receive periodic HTML email updates fetched from GitHub. Users can also unsubscribe through a secure email verification process.

💡 Key Features:
🔐 Email Verification: Users enter their email and receive a 6-digit verification code via email. After verification, emails are stored securely in registered_emails.txt.

📤 CRON Integration: A scheduled CRON job (via setup_cron.sh) runs every 5 minutes and sends formatted GitHub timeline events to verified users.

📥 Unsubscribe Mechanism: Each email contains an unsubscribe link. Users are re-verified before their email is removed.

📧 HTML Emails: All emails are sent in well-formatted HTML using the PHP mail() function, and tested locally via Mailpit.

🛠️ Mailpit Integration: Used Mailpit as a local SMTP server to test and inspect outgoing emails in real-time.

🖥️ How to Run the Project:
Environment:

PHP 8.3

XAMPP (Apache + PHP)

Mailpit (for local email testing)

Bash (for CRON script execution)

Steps to Run:

Clone the repo and run XAMPP Apache server.

Open Mailpit (mailpit command) and visit http://localhost:8025.

Navigate to the project: http://localhost/github-timeline/src/index.php

Submit your email → enter code from Mailpit inbox.

Run setup_cron.sh to configure the CRON job.

Timeline updates and unsubscribe emails will be handled automatically.

📁 Project Structure Highlights:
index.php → Handles registration and email verification

unsubscribe.php → Manages unsubscription and confirmation

functions.php → Core logic (mail, registration, GitHub fetch, etc.)

cron.php → Sends timeline updates via CRON

setup_cron.sh → Adds a scheduled CRON job automatically

registered_emails.txt → Text file used as an email "database"

🏆 Outcome
Successfully implemented email-based authentication, CRON-based notifications, and unsubscribe workflows without using any external libraries or databases — adhering strictly to competition rules.

