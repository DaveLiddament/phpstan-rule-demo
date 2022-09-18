<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanRuleDemo;


#[\Attribute(\Attribute::TARGET_CLASS)]
class Friend
{
    /** @param class-string $friend */
    public function __construct(
        public string $friend,
    ) {
    }
}
