# TODO: Add Email Notifications for Registration Success/Denial

## Tasks

- [x] Create app/Mail/RegistrationNotification.php Mailable class for sending registration outcome emails
- [x] Update app/Http/Controllers/RegisterController.php to send success email after user creation
- [x] Update app/Http/Controllers/RegisterController.php to send denial email on validation failure or exception
- [ ] Test email functionality (ensure mail config is set for actual sending if needed)
