<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Account Created</title>
</head>
<body>
    <p>Dear {{ $user->first_name }},</p>

    <p>We are pleased to inform you that an account has been created for you in our school management system. Your login credentials are as follows:</p>

    <ul>
        <li>Email: {{ $user->email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <p>Please use these credentials to log in to our system at <a href="{{ config('app.user_url') }}">{{ config('app.user_url') }}</a>. Once you have logged in, you will be able to access all of the features and resources available to you as a registered user.</p>

    <p>If you have any questions or concerns, please do not hesitate to contact us at schoolmanagement@gmail.com.</p>

    <p>Thank you for choosing our school management system. We look forward to serving you!</p>

    <p>Best regards,<br>
    School management
    </p>
</body>
</html>