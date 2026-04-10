<?php

declare(strict_types=1);

namespace Tests\View\Components\AspectRatio;

use App\View\Components\AspectRatio\Dimensions;
use PHPUnit\Framework\TestCase;

final class DimensionsTest extends TestCase
{
    public function test_square_aliases(): void
    {
        self::assertSame([1, 1], Dimensions::parse('square'));
        self::assertSame([1, 1], Dimensions::parse('1/1'));
    }

    public function test_custom_fraction(): void
    {
        self::assertSame([4, 3], Dimensions::parse('4/3'));
    }

    public function test_invalid_dimensions_fallback(): void
    {
        self::assertSame([16, 9], Dimensions::parse('0/5'));
    }
}
