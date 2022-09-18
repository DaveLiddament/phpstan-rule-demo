<?php

declare(strict_types=1);



namespace DaveLiddament\PhpstanRules;

use DaveLiddament\PhpstanRuleDemo\Friend;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class TextMessageSenderCallCheckRule implements Rule
{

    public function __construct(
        private ReflectionProvider $reflectionProvider,
    ) {
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $callingClass = $scope->getClassReflection()->getName();
        $type = $scope->getType($node->var);

        foreach ($type->getReferencedClasses() as $targetClass) {

            $nativeReflection = $this->reflectionProvider->getClass($targetClass)->getNativeReflection();
            $friendAttributes = $nativeReflection->getAttributes(Friend::class);
            if (count($friendAttributes) !== 1) {
                continue;
            }

            $friendAttribute = $friendAttributes[0];
            $friendArguments = $friendAttribute->getArguments();
            if (count($friendArguments) !== 1) {
                continue;
            }

            $friend = $friendArguments[0];

            if ($callingClass !== $friend) {
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
