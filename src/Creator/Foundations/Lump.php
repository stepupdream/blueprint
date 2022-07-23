<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class Lump extends Base
{
    /**
     * @var string[]
     */
    protected array $requiredKeys = [
        'read_path',
        'output_path',
        'extension',
        'template_blade_file',
        'is_override',
    ];

    /**
     * @var string
     */
    protected string $readPath;

    /**
     * @var string
     */
    protected string $outputPath;

    /**
     * @var bool
     */
    protected bool $isOverride;

    /**
     * @var string[]
     */
    protected array $exceptFileNames;

    /**
     * @var string
     */
    protected string $commonFileName;

    /**
     * Lump constructor.
     *
     * @param  mixed[]  $foundationConfig
     * @param  \StepUpDream\Blueprint\Creator\Supports\TextSupport  $textSupport
     */
    public function __construct(
        array $foundationConfig,
        TextSupport $textSupport
    ) {
        $this->verifyKeys($foundationConfig, $this->requiredKeys);
        parent::__construct($foundationConfig, $textSupport);

        // required
        $this->readPath = (string) $foundationConfig['readPath'];
        $this->outputPath = (string) $foundationConfig['outputPath'];
        $this->isOverride = (bool) $foundationConfig['isOverride'];

        // option
        $this->exceptFileNames = $foundationConfig['except_file_names'] ?? [];
        $this->commonFileName = $foundationConfig['common_file_name'] ?? '';
    }

    /**
     * Get readPath
     *
     * @return string
     */
    public function readPath(): string
    {
        return $this->readPath;
    }

    /**
     * Get outputPath
     *
     * @return string
     */
    public function outputPath(): string
    {
        return $this->outputPath;
    }

    /**
     * Get isOverride
     *
     * @return bool
     */
    public function isOverride(): bool
    {
        return $this->isOverride;
    }

    /**
     * Get exceptFileNames
     *
     * @return string[]
     */
    public function exceptFileNames(): array
    {
        return $this->exceptFileNames;
    }

    /**
     * Get commonFileName
     *
     * @return string
     */
    public function commonFileName(): string
    {
        return $this->commonFileName;
    }
}
