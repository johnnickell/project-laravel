<?php

declare(strict_types=1);

namespace Tests\Feature;

use DateTimeImmutable;
use Fight\Common\Application\Auth\Authenticator;
use Fight\Common\Application\Auth\Exception\AuthException;
use Fight\Common\Application\Auth\Exception\TokenException;
use Fight\Common\Application\Auth\RequestService;
use Fight\Common\Application\Auth\Security\TokenDecoder;
use Fight\Common\Application\Auth\Security\TokenEncoder;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\Attributes\TestWith;
use RuntimeException;
use Tests\TestCase;

final class FightSecurityTest extends TestCase
{
    #[TestWith([RequestService::class, 'hmac.private', '', 'FIGHT_HMAC_PRIVATE'])]
    #[TestWith([RequestService::class, 'hmac.public', null, 'FIGHT_HMAC_PUBLIC'])]
    #[TestWith([Authenticator::class, 'hmac.private', '   ', 'FIGHT_HMAC_PRIVATE'])]
    #[TestWith([Authenticator::class, 'hmac.public', null, 'FIGHT_HMAC_PUBLIC'])]
    #[TestWith([TokenEncoder::class, 'jwt.secret', '', 'FIGHT_JWT_SECRET'])]
    #[TestWith([TokenDecoder::class, 'jwt.secret', 42, 'FIGHT_JWT_SECRET'])]
    public function test_missing_credentials_reject_security_use_without_disclosing_values(
        string $service,
        string $key,
        string|int|null $value,
        string $environmentVariable,
    ): void {
        config(['fight.security.'.$key => $value]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($environmentVariable.' must be configured before resolving Fight security services.');

        $this->app->make($service);
    }

    public function test_tokens_signed_with_the_application_key_can_be_read(): void
    {
        $token = $this->app->make(TokenEncoder::class)->encode(['sub' => 'application-user'], new DateTimeImmutable('+5 minutes'));
        $claims = $this->app->make(TokenDecoder::class)->decode($token);

        self::assertSame('application-user', $claims['sub']);
    }

    public function test_tokens_signed_with_a_different_application_key_are_rejected(): void
    {
        $token = $this->app->make(TokenEncoder::class)->encode(['sub' => 'application-user'], new DateTimeImmutable('+5 minutes'));
        config(['fight.security.jwt.secret' => bin2hex(str_repeat('different-key-', 4))]);

        $this->expectException(TokenException::class);

        $this->app->make(TokenDecoder::class)->decode($token);
    }

    public function test_requests_signed_with_application_credentials_are_accepted(): void
    {
        config(['fight.security.hmac.public' => 'application-client']);
        $request = new ServerRequest('POST', 'https://example.test/hooks', [], '{"ok":true}');
        $signed = $this->app->make(RequestService::class)->signRequest($request);

        self::assertSame('application-client', $signed->getHeaderLine('Credential'));
        self::assertTrue($this->app->make(Authenticator::class)->validate($signed));
    }

    public function test_requests_signed_with_a_different_application_key_are_rejected(): void
    {
        $request = new ServerRequest('POST', 'https://example.test/hooks', [], '{"ok":true}');
        $signed = $this->app->make(RequestService::class)->signRequest($request);
        config(['fight.security.hmac.private' => bin2hex(str_repeat('different-key-', 4))]);

        $this->expectException(AuthException::class);
        $this->expectExceptionMessage('Invalid signature');

        $this->app->make(Authenticator::class)->validate($signed);
    }

    public function test_requests_outside_the_application_time_tolerance_are_rejected(): void
    {
        config(['fight.security.hmac.time_tolerance' => 5]);
        $request = new ServerRequest('POST', 'https://example.test/hooks', [], '{"ok":true}');
        $signed = $this->app->make(RequestService::class)->signRequest($request);
        $lateRequest = new ServerRequest(
            $signed->getMethod(),
            $signed->getUri(),
            $signed->getHeaders(),
            $signed->getBody(),
            $signed->getProtocolVersion(),
            ['REQUEST_TIME' => (int) $signed->getHeaderLine('X-Timestamp') + 6],
        );

        $this->expectException(AuthException::class);
        $this->expectExceptionMessage('Timestamp out of bounds');

        $this->app->make(Authenticator::class)->validate($lateRequest);
    }
}
