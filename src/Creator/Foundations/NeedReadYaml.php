<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

trait NeedReadYaml
{
    /**
     * @var string
     */
    protected string $readPath;

    /**
     * @var string[]
     */
    protected array $exceptFileNames;

    /**
     * @var string
     */
    protected string $commonFileName;

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
     * Get commonFileName.
     *
     * @return string
     */
    public function commonFileName(): string
    {
        return $this->commonFileName;
    }

    /**
     * Set need read yaml value.
     *
     * @param  mixed[]  $foundationConfig
     * @return void
     */
    protected function setNeedReadYaml(array $foundationConfig): void
    {
        $this->readPath = (string) $foundationConfig['read_path'];
        $this->groupKeyName = $foundationConfig['group_key_name'] ?? '';
        $this->exceptFileNames = $foundationConfig['except_file_names'] ?? [];
        $this->commonFileName = $foundationConfig['common_file_name'] ?? '';
    }
}
