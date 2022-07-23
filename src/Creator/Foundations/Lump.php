<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class Lump extends Base implements NeedReadYamlInterface
{
    use NeedReadYaml;

    /**
     * @var string[]
     */
    protected array $requiredKeys = [
        'read_path',
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
        $this->setNeedReadYaml($foundationConfig);
        parent::__construct($foundationConfig, $textSupport);

        $this->outputPath = (string) $foundationConfig['output_path'];
        $this->isOverride = (bool) $foundationConfig['is_override'];
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
}
