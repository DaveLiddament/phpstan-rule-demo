<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanRuleDemo;


class RandomCode
{
    public function __construct(
        private TextMessageSender $textMessageSender,
    ) {
    }

    public function doSomething(): void
    {
        $this->textMessageSender->sendMessage(); // Should not be allowed
    }
}
