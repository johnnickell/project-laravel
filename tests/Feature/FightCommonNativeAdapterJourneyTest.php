<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Adapter\Http\Laravel\JSendResponse;
use Fight\Common\Application\Repository\TransactionalUnitOfWork;
use Fight\Common\Application\Routing\UrlGenerator;
use Fight\Common\Domain\Type\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Tests\TestCase;

final class FightCommonNativeAdapterJourneyTest extends TestCase
{
    public function test_transactional_unit_of_work_commits_and_rolls_back_through_the_laravel_adapter(): void
    {
        Schema::dropIfExists('fight_transactional_records');
        Schema::create('fight_transactional_records', static function ($table): void {
            $table->id();
            $table->string('reference');
        });

        $unitOfWork = $this->app->make(TransactionalUnitOfWork::class);
        $result = $unitOfWork->commitTransactional(static function (): string {
            DB::table('fight_transactional_records')->insert(['reference' => 'committed']);

            return 'committed';
        });

        self::assertSame('committed', $result);
        self::assertSame(['committed'], DB::table('fight_transactional_records')->pluck('reference')->all());

        try {
            $unitOfWork->commitTransactional(static function (): never {
                DB::table('fight_transactional_records')->insert(['reference' => 'rolled-back']);

                throw new RuntimeException('rollback');
            });
            self::fail('The failing transactional operation must be rethrown.');
        } catch (RuntimeException $exception) {
            self::assertSame('rollback', $exception->getMessage());
        }

        self::assertSame(['committed'], DB::table('fight_transactional_records')->pluck('reference')->all());
    }

    public function test_url_generator_creates_the_named_home_route_with_query_data(): void
    {
        $url = $this->app->make(UrlGenerator::class)->generate('home', query: ['source' => 'receipt'], absolute: false);

        self::assertSame('/?source=receipt', $url);
    }

    public function test_jsend_response_returns_a_native_laravel_json_response(): void
    {
        $response = JSendResponse::success(new NativeAdapterPresentation(['profile' => 'complete']), 201);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(201, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('Content-Type'));
        self::assertSame(['status' => 'success', 'data' => ['profile' => 'complete']], $response->getData(true));
    }
}

final readonly class NativeAdapterPresentation implements Arrayable
{
    /** @param array<string, string> $data */
    public function __construct(private array $data) {}

    /** @return array<string, string> */
    public function toArray(): array
    {
        return $this->data;
    }
}
