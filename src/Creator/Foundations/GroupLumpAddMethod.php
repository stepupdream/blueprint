<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class GroupLumpAddMethod extends Base
{
    use OutputDirectory;
    use NeedReadYaml;

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
        'method_name_type',
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
    protected string $methodNameType;

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
        $this->setOutputDirectory($foundationConfig);
        $this->setNeedReadYaml($foundationConfig);
        parent::__construct($foundationConfig, $textSupport);

        $this->methodKeyName = (string) $foundationConfig['method_key_name'];
        $this->addTemplateBladeFile = (string) $foundationConfig['add_template_blade_file'];
        $this->methodNameType = $foundationConfig['method_name_type'];
    }

    /**
     * Get methodKeyName.
     *
     * @return string
     */
    public function methodKeyName(): string
    {
        return $this->methodKeyName;
    }

    /**
     * Get addTemplateBladeFile.
     *
     * @return string
     */
    public function addTemplateBladeFile(): string
    {
        return $this->addTemplateBladeFile;
    }

    /**
     * Get methodNameType.
     *
     * @return string
     */
    public function methodNameType(): string
    {
        return $this->methodNameType;
    }
}
