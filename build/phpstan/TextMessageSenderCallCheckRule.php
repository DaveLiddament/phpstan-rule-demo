<?php

declare(strict_types=1);



namespace DaveLiddament\PhpstanRules;

use DaveLiddament\PhpstanRuleDemo\TextMessageQueueProcessor;
use DaveLiddament\PhpstanRuleDemo\TextMessageSender;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class TextMessageSenderCallCheckRule implements Rule
{

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $callingClass = $scope->getClassReflection()->getName();

        if ($callingClass === TextMessageQueueProcessor::class) {
            return [];
        }

        $type = $scope->getType($node->var);

        foreach ($type->getReferencedClasses() as $targetClass) {
            if ($targetClass === TextMessageSender::class) {
                return [
                    RuleErrorBuilder::message(
                        sprintf(
                            "Can not call %s from %s",
                            $targetClass,
                            $callingClass
                        )
                    )->build()
                ];
            }
        }

        return [];
    }
}
