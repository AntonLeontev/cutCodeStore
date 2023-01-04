<?php

namespace Src\Services\Telegram;

use Src\Services\Telegram\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
	public const HOST = 'https://api.telegram.org/bot';

	public static function sendMessage(string $token, int $chatId, string $message): bool
	{
		try {
			$response = Http::post(
				self::HOST . $token . '/sendMessage',
				[
					'chat_id' => $chatId,
					'text' => $message
				]
			)
				->throw()->json();

			return $response['ok'] ?? false;
		} catch (\Throwable $th) {
			report(new TelegramBotApiException($th->getMessage()));
				
			return false;
		}
	}
}
