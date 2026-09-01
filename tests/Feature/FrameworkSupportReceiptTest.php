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
        self::assertSame(['package' => 'johnnickell/fight-common', 'version' => '1.2.0-dev', 'reference' => 'cfb951c368f9b40fe460e931011b092d8eef6509'], $receipt['candidate']);
        self::assertSame('laravel', $receipt['framework']['name']);
        self::assertSame('13.30.0', $receipt['framework']['version']);
        self::assertSame([
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\BroadcastingServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\MessagingServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\PersistenceServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\SecurityServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\RoutingServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\CacheServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\HttpServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\HttpClientServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\LoggingServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\MailServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\MetricsServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\ProcessServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\TemplatingServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\FileStorageServiceProvider',
            'Fight\\Common\\Adapter\\ServiceContainer\\Laravel\\FilesystemServiceProvider',
        ], $receipt['framework']['providers']);
        foreach ($receipt['capabilities'] as $capability => $state) {
            self::assertContains($state, ['ship', 'wire', 'unavailable'], sprintf('%s has an invalid capability state.', $capability));
        }
        foreach ($receipt['journeys'] as $journey) {
            self::assertSame(['name', 'status', 'evidence'], array_keys($journey));
            self::assertContains($journey['status'], ['passed', 'failed', 'unavailable', 'skipped', 'indeterminate']);
            self::assertNotSame('', $journey['name']);
            self::assertNotSame('', $journey['evidence']);
        }
        self::assertSame(hash_file('sha256', $root.'/composer.lock'), $receipt['lock_sha256']);
        $lowestLock = $root.'/evidence/framework-support/composer-lowest.lock';
        $lowestDigest = trim((string) file_get_contents($root.'/evidence/framework-support/composer-lowest.lock.sha256'));
        self::assertFileExists($lowestLock);
        self::assertSame(hash_file('sha256', $lowestLock).'  evidence/framework-support/composer-lowest.lock', $lowestDigest);
        $lowest = json_decode((string) file_get_contents($lowestLock), true, flags: JSON_THROW_ON_ERROR);
        $fightCommon = array_values(array_filter($lowest['packages'], static fn (array $package): bool => $package['name'] === 'johnnickell/fight-common'));
        self::assertCount(1, $fightCommon);
        self::assertSame('dev-develop', $fightCommon[0]['version']);
        self::assertSame('cfb951c368f9b40fe460e931011b092d8eef6509', $fightCommon[0]['source']['reference']);
        self::assertSame('passed', $receipt['result']);
        self::assertSame('ship', $receipt['capabilities']['hmac_request_signing']);
        self::assertTrue(self::hasCanonicalOutcome($receipt));

        $content = $receipt;
        unset($content['content_id'], $content['evidence']['receipt_sha256']);
        self::assertSame(hash('sha256', json_encode($content, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)), $receipt['content_id']);

        $digest = $receipt;
        unset($digest['evidence']['receipt_sha256']);
        self::assertSame(hash('sha256', json_encode($digest, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)), $receipt['evidence']['receipt_sha256']);
    }

    public function test_non_passing_receipts_require_one_resumable_action_and_a_non_passing_journey(): void
    {
        $receipt = [
            'result' => 'failed',
            'journeys' => [['name' => 'journey', 'status' => 'failed', 'evidence' => 'test']],
            'next_action' => ['action' => 'Resolve the failing journey.'],
        ];

        self::assertTrue(self::hasCanonicalOutcome($receipt));

        $receipt['next_action'] = null;
        self::assertFalse(self::hasCanonicalOutcome($receipt));
    }

    /** @param array{result: string, journeys: list<array{name: string, status: string, evidence: string}>, next_action: array{action: string}|null} $receipt */
    private static function hasCanonicalOutcome(array $receipt): bool
    {
        $allPassed = array_all($receipt['journeys'], static fn (array $journey): bool => $journey['status'] === 'passed');

        if ($receipt['result'] === 'passed') {
            return $receipt['next_action'] === null && $allPassed;
        }

        return in_array($receipt['result'], ['failed', 'unavailable', 'skipped', 'indeterminate'], true)
            && ! $allPassed
            && is_array($receipt['next_action'])
            && array_keys($receipt['next_action']) === ['action']
            && is_string($receipt['next_action']['action'])
            && $receipt['next_action']['action'] !== '';
    }
}
