<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanRuleDemo;


class TextMessageSender
{

    /*
     * Should only be called from TextMessageQueueProcessor
     */
    public function sendMessage(): void
    {

    }
}
