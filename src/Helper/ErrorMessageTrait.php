<?php

namespace Cleitoncunha\Bird\Helper;

trait ErrorMessageTrait
{
    private function addErrorMessage(string $message): void
    {
        $_SESSION['error_message'] = $message;
    }
}