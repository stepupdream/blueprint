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
     * @var string
     */
    protected string $groupKeyName;

    /**
     * Get groupKeyName.
     *
     * @return string
     */
    public function groupKeyName(): string
    {
        return $this->groupKeyName;
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
     * Get commonFileName.
     *
     * @return string
     */
    public function commonFileName(): string
    {
        return $this->commonFileName;
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
            $result[$key] = $this->replaceForBlade($fileName, $option, $yamlFile);
        }

        return $result;
    }

    /**
     * Replace key for replacement.
     *
     * @param  string  $fileName
     * @param  string  $value
     * @param  mixed  $yamlFile
     * @return string
     */
    public function replaceForBlade(string $fileName, string $value, mixed $yamlFile): string
    {
        $groupName = $yamlFile[$this->groupKeyName] ?? '';
        if (! empty($groupName) && str_contains($value, '@groupName')) {
            $value = str_replace('@groupName', $groupName, $value);
        }

        if (! empty($fileName) && str_contains($value, '@fileName')) {
            $value = str_replace('@fileName', $fileName, $value);
        }

        return $value;
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
