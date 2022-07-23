<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class IndividualNotRead extends Base
{
    /**
     * @var string[]
     */
    protected array $requiredKeys = [
        'output_path',
        'template_blade_file',
        'is_override',
    ];

    /**
     * @var string
     */
    protected string $outputPath;

    /**
     * @var bool
     */
    protected bool $isOverride;

    /**
     * IndividualNotRead constructor.
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

        $this->outputPath = (string) $foundationConfig['output_path'];
        $this->isOverride = (bool) $foundationConfig['is_override'];
    }

    /**
     * options for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return mixed[]
     */
    public function optionsForBlade(string $fileName, mixed $yamlFile): array
    {
        $result = [];
        foreach ($this->options as $key => $option) {
            $result[$key] = $option;
        }

        return $result;
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
     * Get outputPath
     *
     * @return string
     */
    public function outputPath(): string
    {
        return $this->outputPath;
    }
}
