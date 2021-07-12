<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  */
    public function user_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('user', [
                'user_id',

            ]), 1);
    }
}