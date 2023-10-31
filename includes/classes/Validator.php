<?php

class Validator
{


    /**
     * Validate Username.
     * @param $username
     *
     * @return bool|string
     */
    public static function username($username, $min = 3, $max = 30): bool|string
    {
        $username_filter = [
            'options' => [
                'regexp' => '/[^a-z0-9 _]/i' // only A-Z, a-z, space, underscore allowed.
            ]
        ];

        if(strlen($username) < $min) {
            $_SESSION['errors']['username'] = "Username should be at least {$min} characters long";
            return false;
        }
        if(strlen($username) > $max) {
            $_SESSION['errors']['username'] = "Username should be max {$max} characters long";
            return false;
        }

        $filteredName = filter_var($username, FILTER_VALIDATE_REGEXP, $username_filter);
        return $filteredName === false ? $username : true;
    }

    /**
     * Validate password.
     * @param $pass
     *
     * @return bool|string
     */
    public static function password($pass): bool|string
    {
        // Minimum 8 characters having one lowercase, uppercase, symbol and number.
        $password_filter = [
            'options' => [
                'regexp' => "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/"
            ]
        ];

        return filter_var($pass, FILTER_VALIDATE_REGEXP, $password_filter) ?? false;
    }

    /**
     * Check if the mail is valid or not.
     * @param $mail
     *
     * @return bool|string
     */
    public static function email($mail): bool|string
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL) ?? false;
    }

}
