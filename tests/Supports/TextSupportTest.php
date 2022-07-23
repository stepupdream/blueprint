<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Supports;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;

class TextSupportTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderConvertNameByConvertType
     */
    public function convertNameByConvertType(string $convertType, string $name, string $testResult): void
    {
        $textSupport = new TextSupport();
        $result = $textSupport->convertName($convertType, $name);

        self::assertSame($result, $testResult);
    }

    /**
     * dataProvider.
     *
     * @return string[]
     */
    public function dataProviderConvertNameByConvertType(): array
    {
        return [
            ['studly', 'base_controller', 'BaseController'],
            ['upper_camel', 'base_controller', 'BaseController'],
            ['camel', 'base_controller', 'baseController'],
            ['snake', 'BaseController', 'base_controller'],
            ['kebab', 'BaseController', 'base-controller'],
            ['singular_studly', 'total_waves', 'TotalWave'],
            ['singular_upper_camel', 'total_waves', 'TotalWave'],
            ['singular_camel', 'total_waves', 'totalWave'],
            ['singular_snake', 'total_waves', 'total_wave'],
            ['singular_kebab', 'TotalWave', 'total-wave'],
            ['plural_studly', 'total_wave', 'TotalWaves'],
            ['plural_upper_camel', 'total_wave', 'TotalWaves'],
            ['plural_camel', 'total_wave', 'totalWaves'],
            ['plural_snake', 'total_wave', 'total_waves'],
            ['plural_kebab', 'TotalWave', 'total-waves'],
        ];
    }

    /**
     * @test
     */
    public function convertFileFullPathToNamespace(): void
    {
        $textSupport = new TextSupport();
        $result = $textSupport->convertFileFullPathToNamespace(app_path('Http/Controllers/NewsWatchController'));

        self::assertSame('App\Http\Controllers', $result);
    }

    /**
     * @test
     */
    public function convertFileFullPathToClassPath(): void
    {
        $textSupport = new TextSupport();
        $result = $textSupport->convertFileFullPathToClassPath(app_path('Http/Controllers/NewsWatchController'));

        self::assertSame('App\Http\Controllers\NewsWatchController', $result);
    }
}
