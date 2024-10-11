function getMessage($str){
    $message = {
        'redirect': 'You will be redirected, please wait...',
        'success.login': "Login successful. Welcome back!",
        'success.profile_user_update': "Your personal information has updated successfully!",
        'success.profile_school_update': "Your school information has updated successfully!",
        'success.create_password': "Password created successfully. You can now login with your new password.",
        'success.update_password': "Password updated successfully. You can now login with your new password.",

        'error.generic': 'An error occurred. Please try again later.',
        'error.server_timeout': 'Server timeout. Please try again later.',
        'error.email_required': 'Email is required.',
        'error.password_required': 'Password is required.'
    }
    return ($message[$str]) ? $message[$str] : '';
}