<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanRuleDemo;


class TextMessageQueueProcessor
{

    public function __construct(
        private TextMessageSender $textMessageSender,
    ){
    }

    public function processMessage(): void
    {
        $this->textMessageSender->sendMessage(); // OK
    }

}
