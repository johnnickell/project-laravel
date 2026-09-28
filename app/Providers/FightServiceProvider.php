<?php

declare(strict_types=1);

namespace App\Providers;

use Fight\Common\Adapter\Auth\Hmac\HmacAuthenticator;
use Fight\Common\Adapter\Auth\Hmac\HmacRequestService;
use Fight\Common\Adapter\Auth\Security\JwtDecoder;
use Fight\Common\Adapter\Auth\Security\JwtEncoder;
use Fight\Common\Adapter\ServiceContainer\Laravel\PersistenceServiceProvider;
use Fight\Common\Application\Auth\Authenticator;
use Fight\Common\Application\Auth\RequestService;
use Fight\Common\Application\Auth\Security\TokenDecoder;
use Fight\Common\Application\Auth\Security\TokenEncoder;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

final class FightServiceProvider extends ServiceProvider
{
    /**
     * Registers the retained transaction and fail-closed security integration
     */
    public function register(): void
    {
        $this->app->register(PersistenceServiceProvider::class);

        $this->app->singleton(Authenticator::class, static function (Container $app): HmacAuthenticator {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new HmacAuthenticator(
                self::requiredSecurityValue($config, 'fight.security.hmac.public', 'FIGHT_HMAC_PUBLIC'),
                self::requiredSecurityValue($config, 'fight.security.hmac.private', 'FIGHT_HMAC_PRIVATE'),
                (int) $config->get('fight.security.hmac.time_tolerance', 300),
            );
        });
        $this->app->singleton(RequestService::class, static function (Container $app): HmacRequestService {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new HmacRequestService(
                self::requiredSecurityValue($config, 'fight.security.hmac.public', 'FIGHT_HMAC_PUBLIC'),
                self::requiredSecurityValue($config, 'fight.security.hmac.private', 'FIGHT_HMAC_PRIVATE'),
            );
        });
        $this->app->singleton(TokenEncoder::class, static function (Container $app): JwtEncoder {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new JwtEncoder(
                self::requiredSecurityValue($config, 'fight.security.jwt.secret', 'FIGHT_JWT_SECRET'),
                (string) $config->get('fight.security.jwt.algorithm', 'HS256'),
            );
        });
        $this->app->singleton(TokenDecoder::class, static function (Container $app): JwtDecoder {
            $config = $app->make('config');
            assert($config instanceof Config);

            return new JwtDecoder(
                self::requiredSecurityValue($config, 'fight.security.jwt.secret', 'FIGHT_JWT_SECRET'),
                (string) $config->get('fight.security.jwt.algorithm', 'HS256'),
            );
        });
    }

    /**
     * Rejects absent credentials without disclosing their values
     */
    private static function requiredSecurityValue(Config $config, string $key, string $environmentVariable): string
    {
        $value = $config->get($key);

        if (! is_string($value) || trim($value) === '') {
            throw new RuntimeException(sprintf('%s must be configured before resolving Fight security services.', $environmentVariable));
        }

        return $value;
    }
}
