<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class Individual extends OutputDirectory
{
    /**
     * @var string[]
     */
    protected array $requiredKeys = [
        'read_path',
        'output_directory_path',
        'extension',
        'template_blade_file',
        'is_override',
    ];

    /**
     * @var bool
     */
    protected bool $isOverride;

    /**
     * Individual constructor.
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

        $this->isOverride = (bool) $foundationConfig['is_override'];
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
