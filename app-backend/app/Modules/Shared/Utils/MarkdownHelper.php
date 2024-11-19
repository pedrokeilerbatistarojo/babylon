<?php

namespace App\Modules\Shared\Utils;

class MarkdownHelper
{
    public static function escapeMarkdown(string $text): string
    {
        $specialChars = [
            '_', '*', '[', ']', '(', ')', '~', '`', '>', '#',
            '+', '-', '=', '|', '{', '}', '.', '!',
        ];

        foreach ($specialChars as $char) {
            $text = str_replace($char, '\\'.$char, $text);
        }

        return $text;
    }
}
