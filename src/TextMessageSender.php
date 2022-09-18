<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanRuleDemo;


#[Friend(TextMessageQueueProcessor::class)]
class TextMessageSender
{

    public function sendMessage(): void
    {

    }
}
