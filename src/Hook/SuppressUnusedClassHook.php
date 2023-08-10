<?php

declare(strict_types=1);

namespace Ghostwriter\PsalmPlugin\Hook;

use Ghostwriter\PsalmPlugin\AbstractBeforeAddIssueEventHook;

use PHPUnit\Framework\TestCase;
use Psalm\Issue\UnusedClass;
use Psalm\Plugin\EventHandler\Event\BeforeAddIssueEvent;

final class SuppressUnusedClassHook extends AbstractBeforeAddIssueEventHook
{
    /**
     * @return null|false
     */
    public static function beforeAddIssue(BeforeAddIssueEvent $event): ?bool
    {
        $codeIssue = $event->getIssue();
        if (! $codeIssue instanceof UnusedClass) {
            return self::IGNORE;
        }

        $className = $codeIssue->fq_classlike_name;

        if (str_contains($className, __NAMESPACE__)) {
            // Hooks are autoloaded
            return self::SUPPRESS;
        }

        // if ($event->getCodebase()->classExtends($codeIssue->fq_classlike_name, TestCase::class)) {
        //  todo: add condtion to suppress unused classes that extend TestCase
        //     return self::SUPPRESS;
        // }

        return self::IGNORE;
    }
}
