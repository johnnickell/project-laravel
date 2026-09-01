<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

final class FrameworkSupportReceiptTest extends TestCase
{
    public function test_the_committed_receipt_is_a_deterministic_passing_laravel_receipt(): void
    {
        $root = dirname(__DIR__, 2);
        $receipt = json_decode((string) file_get_contents($root.'/evidence/framework-support/receipt-v1.json'), true, flags: JSON_THROW_ON_ERROR);

        self::assertSame(['schema_version', 'content_id', 'candidate', 'framework', 'lock_sha256', 'capabilities', 'journeys', 'result', 'evidence', 'next_action'], array_keys($receipt));
        self::assertSame('fight-common.framework-support-receipt/v1', $receipt['schema_version']);
        self::assertSame(['package' => 'johnnickell/fight-common', 'version' => 'dev-develop', 'reference' => '4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16'], $receipt['candidate']);
        self::assertSame('laravel', $receipt['framework']['name']);
        self::assertSame(hash_file('sha256', $root.'/composer.lock'), $receipt['lock_sha256']);
        self::assertSame('passed', $receipt['result']);
        self::assertNull($receipt['next_action']);

        $content = $receipt;
        unset($content['content_id'], $content['evidence']['receipt_sha256']);
        self::assertSame(hash('sha256', json_encode($content, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)), $receipt['content_id']);

        $digest = $receipt;
        unset($digest['evidence']['receipt_sha256']);
        self::assertSame(hash('sha256', json_encode($digest, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)), $receipt['evidence']['receipt_sha256']);
    }
}
