<?php

namespace API\Clients;

class Documentation{
    private function __construct() {}

    public static function createUser(): string {
        return <<<TEXT
        Endpoint Functional Information:
            Name: /create-account
            Method: POST
            Authentication: Not Required
            Payload: 
                Type: JSON
                Fields:
                    first_name (requried) (string) (255): first name of the user
                    last_name (requried) (string) (255): last name of the user
                    email (requried) (string) (255): email of the user
                    password (requried) (string) (16777215): desired passphrase
                    confirm_password (requried) (string) (16777215): repetition of desired passphrase
            Responses:
                Status Codes:
                    420: Missing Mandatory Field(s).
                    421: Passwords Mismatch.
                    422: Invalid Email Address.
                    422: User Already Exists.
                    400: Unable to create user - System Error.
                    200: Submittion Succeeded.
                Payload:
                    Type: JSON
                    Fields:
                        error (int): 0 -> Success, 1 -> Failed
                        message (string): Textual information about the status of the request
        Claima Technologies.
TEXT;
    }
}