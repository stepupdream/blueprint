<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

class Migration extends Base
{
    /**
     * @var string[]
     */
    protected array $requiredKeys = [
        'read_path',
        'connection',
        'output_directory_path',
        'template_blade_file',
        'template_update_blade_file',
    ];

    /**
     * @var string
     */
    protected string $readPath;

    /**
     * @var string[]
     */
    protected mixed $exceptFileNames;

    /**
     * @var string
     */
    protected string $outputDirectoryPath;

    /**
     * @var string
     */
    protected string $connection;

    /**
     * @var string
     */
    protected string $templateUpdateBladeFile;

    /**
     * Migration constructor.
     *
     * @param  mixed[]  $foundationConfig
     * @param  \StepUpDream\Blueprint\Creator\Supports\TextSupport  $textSupport
     */
    public function __construct(
        array $foundationConfig,
        TextSupport $textSupport
    ) {
        $this->verifyKeys($foundationConfig, $this->requiredKeys);

        $this->readPath = (string) $foundationConfig['read_path'];
        $this->connection = (string) $foundationConfig['connection'];
        $this->exceptFileNames = $foundationConfig['except_file_names'] ?? [];
        $this->outputDirectoryPath = (string) $foundationConfig['output_directory_path'];
        $this->templateUpdateBladeFile = (string) $foundationConfig['template_update_blade_file'];

        parent::__construct($foundationConfig, $textSupport);
    }

    /**
     * Get readPath.
     *
     * @return string
     */
    public function readPath(): string
    {
        return $this->readPath;
    }

    /**
     * Get exceptFileNames.
     *
     * @return string[]
     */
    public function exceptFileNames(): array
    {
        return $this->exceptFileNames;
    }

    /**
     * Get outputDirectoryPath.
     *
     * @return string
     */
    public function outputDirectoryPath(): string
    {
        return $this->outputDirectoryPath;
    }

    /**
     * Get outputDirectoryPathTmp.
     *
     * @return string
     */
    public function outputDirectoryPathTmp(): string
    {
        return $this->outputDirectoryPath.DIRECTORY_SEPARATOR.'tmp';
    }

    /**
     * Get connection.
     *
     * @return string
     */
    public function connection(): string
    {
        return $this->connection;
    }

    /**
     * Get templateUpdateBladeFile.
     *
     * @return string
     */
    public function templateUpdateBladeFile(): string
    {
        return $this->templateUpdateBladeFile;
    }
}
