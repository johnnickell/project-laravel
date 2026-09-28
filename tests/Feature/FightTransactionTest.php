<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fight\Common\Application\Repository\TransactionalUnitOfWork;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Tests\TestCase;

final class FightTransactionTest extends TestCase
{
    public function test_fight_transactions_commit_and_roll_back_on_the_application_connection(): void
    {
        Schema::create('transaction_records', static function ($table): void {
            $table->id();
            $table->string('reference');
        });

        $unitOfWork = $this->app->make(TransactionalUnitOfWork::class);
        $result = $unitOfWork->commitTransactional(static function (): string {
            DB::table('transaction_records')->insert(['reference' => 'committed']);

            return 'committed';
        });

        self::assertSame('committed', $result);
        self::assertSame(['committed'], DB::table('transaction_records')->pluck('reference')->all());

        try {
            $unitOfWork->commitTransactional(static function (): never {
                DB::table('transaction_records')->insert(['reference' => 'rolled-back']);

                throw new RuntimeException('rollback');
            });
            self::fail('The failing transactional operation must be rethrown.');
        } catch (RuntimeException $exception) {
            self::assertSame('rollback', $exception->getMessage());
        }

        self::assertSame(['committed'], DB::table('transaction_records')->pluck('reference')->all());
    }
}
