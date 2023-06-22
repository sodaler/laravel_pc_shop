<?php

declare(strict_types=1);

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Throwable;
use Services\Telegram\Exceptions\TelegramBotApiException;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';


    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text
            ])->throw()->json();

            return $response['ok'] ?? false;
        } catch (Throwable $ex) {
            report(new TelegramBotApiException($ex->getMessage()));
            return false;
        }

    }
}
