<?php

declare(strict_types=1);

namespace Tests\Feature;

use DateTimeImmutable;
use Fight\Common\Adapter\Filesystem\Laravel\LaravelFilesystem;
use Fight\Common\Application\Auth\Authenticator;
use Fight\Common\Application\Auth\RequestService;
use Fight\Common\Application\Auth\Security\TokenDecoder;
use Fight\Common\Application\Auth\Security\TokenEncoder;
use Fight\Common\Application\Filesystem\Exception\FileNotFoundException;
use Fight\Common\Application\Filesystem\Filesystem;
use GuzzleHttp\Psr7\ServerRequest;
use RuntimeException;
use Tests\TestCase;

final class FightCommonSecurityAndFilesystemJourneyTest extends TestCase
{
    public function test_security_services_boot_from_explicit_test_configuration(): void
    {
        self::assertNotSame('', config('fight.security.hmac.public'));
        self::assertNotSame('', config('fight.security.hmac.private'));
        self::assertNotSame('', config('fight.security.jwt.secret'));
        self::assertIsObject($this->app->make(RequestService::class));
        self::assertIsObject($this->app->make(TokenEncoder::class));
    }

    public function test_security_services_fail_clearly_when_required_configuration_is_missing(): void
    {
        config(['fight.security.hmac.private' => '']);

        try {
            $this->app->make(RequestService::class);
            self::fail('Missing HMAC configuration must fail before Fight security services resolve.');
        } catch (RuntimeException $exception) {
            self::assertSame('FIGHT_HMAC_PRIVATE must be configured before resolving Fight security services.', $exception->getMessage());
        }

        config(['fight.security.jwt.secret' => '']);

        try {
            $this->app->make(TokenEncoder::class);
            self::fail('Missing JWT configuration must fail before Fight security services resolve.');
        } catch (RuntimeException $exception) {
            self::assertSame('FIGHT_JWT_SECRET must be configured before resolving Fight security services.', $exception->getMessage());
        }
    }

    public function test_jwt_services_round_trip_through_the_booted_container(): void
    {
        $token = $this->app->make(TokenEncoder::class)->encode(['sub' => 'profile-user'], new DateTimeImmutable('+5 minutes'));
        $claims = $this->app->make(TokenDecoder::class)->decode($token);

        self::assertSame('profile-user', $claims['sub']);
    }

    public function test_hmac_request_signer_and_authenticator_round_trip_through_the_booted_container(): void
    {
        $request = new ServerRequest('POST', 'https://example.test/hooks', ['Content-Type' => 'application/json'], '{"ok":true}', '1.1', [
            'REQUEST_TIME' => time(),
        ]);
        $signed = $this->app->make(RequestService::class)->signRequest($request);

        self::assertInstanceOf(ServerRequest::class, $signed);
        self::assertMatchesRegularExpression('/^\d+$/', $signed->getHeaderLine('X-Timestamp'));
        self::assertTrue($this->app->make(Authenticator::class)->validate($signed));
    }

    public function test_laravel_filesystem_adapter_performs_state_changes_through_the_fight_port(): void
    {
        $filesystem = $this->app->make(Filesystem::class);
        self::assertInstanceOf(LaravelFilesystem::class, $filesystem);

        $root = storage_path('framework/testing/fight-filesystem-'.bin2hex(random_bytes(6)));
        $origin = $root.'/origin';
        $target = $root.'/target';

        try {
            $filesystem->mkdir([$origin.'/nested', $target]);
            $filesystem->put($origin.'/nested/value.txt', 'fight');
            $filesystem->touch($origin.'/nested/value.txt', 1_700_000_000, 1_700_000_000);
            $filesystem->copy($origin.'/nested/value.txt', $target.'/copy.txt');
            $filesystem->rename($target.'/copy.txt', $target.'/renamed.txt');
            $filesystem->mirror($origin, $target, true, true);

            self::assertTrue($filesystem->exists([$origin.'/nested/value.txt', $target.'/nested/value.txt']));
            self::assertSame('fight', $filesystem->get($target.'/nested/value.txt'));
            self::assertSame(1_700_000_000, $filesystem->lastModified($origin.'/nested/value.txt'));
            self::assertSame('txt', $filesystem->fileExt($target.'/nested/value.txt'));
            self::assertTrue($filesystem->isAbsolute($root));
            self::assertFalse($filesystem->isAbsolute('relative/path'));
            self::assertTrue($filesystem->isWritable($target.'/nested/value.txt'));

            $this->expectException(FileNotFoundException::class);
            $filesystem->get($root.'/missing.txt');
        } finally {
            $filesystem->remove($root);
        }
    }
}
