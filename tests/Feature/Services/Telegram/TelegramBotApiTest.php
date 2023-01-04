<?php

namespace Tests\Feature\Services\Telegram;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Src\Services\Telegram\TelegramBotApi;
use Throwable;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;


class TelegramBotApiTest extends TestCase
{
    use InteractsWithExceptionHandling;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fakeSequence()
            ->push(['ok' => true])
            ->push(['ok' => true])
            ->push()
            ->push(['ok' => false]);
    }

    public function test_request_data()
    {
        TelegramBotApi::sendMessage('token', 12, 'message');

        Http::assertSent(function (Request $request) {
            return !is_null($request['chat_id']) &&
                !is_null($request['text']);
        });
    }

    public function test_return_true_on_success()
    {
        $result = TelegramBotApi::sendMessage('token', 12, 'message');

        $this->assertTrue($result);
    }

    public function test_return_false_on_fail()
    {
        $result = TelegramBotApi::sendMessage('token', 12, 'message');

        $this->assertFalse($result);
    }
}
