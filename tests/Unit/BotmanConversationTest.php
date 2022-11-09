<?php

namespace Tests\Unit;

use App\BotmanConversation\OnboardingConversation;
use PHPUnit\Framework\TestCase;

class BotmanConversationTest extends TestCase
{
    /**
     * Verify user's input to bot in a conversation.
     *
     * @return void
     */
    public function test_user_input_to_bot()
    {
        $conversation = new OnboardingConversation();

        // Verify user's input to bot is not a string value
        $response = $conversation->checkUserInput('one', 2);
        $this->assertFalse($response);

        // Verify user's input to bot is not a float value
        $response = $conversation->checkUserInput('0.5', 2);
        $this->assertFalse($response);

        // Verify user's input to bot is an integer but not zero
        $response = $conversation->checkUserInput('0', 2);
        $this->assertFalse($response);

        // Verify user's input to bot is an integer but not lower than zero
        $response = $conversation->checkUserInput('-1', 2);
        $this->assertFalse($response);

        // Verify user's input to bot is an integer but not greater than results length
        $response = $conversation->checkUserInput('3', 2);
        $this->assertFalse($response);

        // Verify user's input to bot is an integer lower than results length
        $response = $conversation->checkUserInput('1', 2);
        $this->assertTrue($response);

        // Verify user's input to bot is an integer equals to results length
        $response = $conversation->checkUserInput('2', 2);
        $this->assertTrue($response);
    }
}
