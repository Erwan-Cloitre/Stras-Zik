<?php

namespace App\Service;

class ValidationService
{
    private const STRING_PATTERN = '/^[a-zA-Z0-9.\- &\_\(\)\!,èéêçàáâ]+$/u';
    private const EMAIL_PATTERN = '/^[a-z0-9._\-]{2,}@[a-z]{2,}\.[a-z]{2,}$/';
    private const INT_PATTERN = '/^[0-9]+$/';
    private const URL_PATTERN = '/^(?:https:\/\/open\.spotify\.com|spotify)([\/:])([^\/]+)([a-z0-9]+)/';

    public function validateString($input)
    {
        if ($input === null || $input === '') {
            return false;
        }

        return preg_match(self::STRING_PATTERN, $input);
    }

    public function validateDate($input)
    {
        $today = date("Y-m-d");

        if ($input === null || $input === '') {
            return false;
        }

        return  $input > $today;
    }

    public function validateMail($input)
    {
        if ($input === null || $input === '') {
            return false;
        }

        return preg_match(self::EMAIL_PATTERN, $input);
    }

    public function validateInt($input)
    {
        if ($input === null || $input === '') {
            return false;
        }

        return preg_match(self::INT_PATTERN, $input);
    }

    public function validateUrl($input)
    {
        if ($input === null || $input === '') {
            return false;
        }
        return preg_match(self::URL_PATTERN, $input);
    }
}
