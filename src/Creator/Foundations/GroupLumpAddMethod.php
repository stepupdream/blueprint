<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class GroupLumpAddMethod extends OutputDirectoryCommon
{
    /**
     * @var string[]
     */
    protected array $requiredKeys = [
        'read_path',
        'output_directory_path',
        'extension',
        'method_key_name',
        'add_template_blade_file',
        'group_key_name',
        'template_blade_file',
    ];

    /**
     * @var string
     */
    protected string $methodKeyName;

    /**
     * @var string
     */
    protected string $addTemplateBladeFile;

    /**
     * @var string
     */
    protected string $groupKeyName;

    /**
     * GroupLumpAddMethod constructor.
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
        $this->methodKeyName = (string) $foundationConfig['method_key_name'];
        $this->addTemplateBladeFile = (string) $foundationConfig['add_template_blade_file'];
        $this->groupKeyName = (string) $foundationConfig['group_key_name'];
    }

    /**
     * Get methodKeyName
     *
     * @return string
     */
    public function methodKeyName(): string
    {
        return $this->methodKeyName;
    }

    /**
     * Get addTemplateBladeFile
     *
     * @return string
     */
    public function addTemplateBladeFile(): string
    {
        return $this->addTemplateBladeFile;
    }

    /**
     * Get groupKeyName
     *
     * @return string
     */
    public function groupKeyName(): string
    {
        return $this->groupKeyName;
    }
}
