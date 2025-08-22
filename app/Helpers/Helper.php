<?php

use Filament\Notifications\Notification;

if (! function_exists('remove_spaces')) {
    /**
     * Remove all spaces from a string
     */
    function remove_spaces($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_string($value)) {
            $value = (string) $value;
        }

        $withoutSpaces = str_replace(' ', '', $value);

        return $withoutSpaces === '' ? null : $withoutSpaces;
    }
}

if (! function_exists('trim_string')) {
    /**
     * Safely trim a string, handling null and non-string values
     */
    function trim_string($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_string($value)) {
            $value = (string) $value;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}

if (! function_exists('sanitize_image_name')) {
    /**
     * Prepare image name by removing spaces and trimming
     */
    function sanitize_image_name($value): ?string
    {
        $withoutSpaces = remove_spaces($value);

        return trim_string($withoutSpaces);
    }

    if (! function_exists('send_success_notification')) {
        /**
         * Sends Filament Notification
         */
        function send_success_notification(string $title = 'Done!', string $body = ''): void
        {
            Notification::make()
                ->title($title)
                ->body($body)
                ->success()
                ->send();
        }
    }

    if (! function_exists('send_error_notification')) {
        /**
         * Sends Filament Notification
         */
        function send_error_notification(string $title = 'Error!', string $body = ''): void
        {
            Notification::make()
                ->title($title)
                ->body($body)
                ->danger()
                ->send();
        }
    }

    if (! function_exists('send_warning_notification')) {
        /**
         * Sends Filament Notification
         */
        function send_warning_notification(string $title = 'Warning!', string $body = ''): void
        {
            Notification::make()
                ->title($title)
                ->body($body)
                ->warning()
                ->send();
        }
    }
}
