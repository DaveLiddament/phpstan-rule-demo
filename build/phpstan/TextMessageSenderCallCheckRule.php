<?php

declare(strict_types=1);



namespace DaveLiddament\PhpstanRules;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class TextMessageSenderCallCheckRule implements Rule
{

    public function __construct(
        private string $allowedCallingClass,
        private string $targetClass
    ) {
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $callingClass = $scope->getClassReflection()->getName();

        if ($callingClass === $this->allowedCallingClass) {
            return [];
        }

        $type = $scope->getType($node->var);

        foreach ($type->getReferencedClasses() as $targetClass) {
            if ($targetClass === $this->targetClass) {
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
