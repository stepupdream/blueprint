<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use LogicException;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;

abstract class Base
{
    /**
     * @var string
     */
    protected string $templateBladeFile;

    /**
     * @var string[]
     */
    protected array $options;

    /**
     * @var string
     */
    protected string $groupKeyName = '';

    /**
     * Base constructor.
     *
     * @param  mixed[]  $foundationConfig
     * @param  \StepUpDream\Blueprint\Creator\Supports\TextSupport  $textSupport
     */
    public function __construct(
        array $foundationConfig,
        protected TextSupport $textSupport
    ) {
        $this->templateBladeFile = (string) $foundationConfig['template_blade_file'];
        $this->options = $foundationConfig['options'] ?? [];
    }

    /**
     * Get templateBladeFile.
     *
     * @return string
     */
    public function templateBladeFile(): string
    {
        return $this->templateBladeFile;
    }

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
     * Options for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return mixed[]
     */
    public function optionsForBlade(string $fileName = '', mixed $yamlFile = []): array
    {
        $result = [];
        foreach ($this->options as $key => $option) {
            $result[$key] = $this->replaceAtSign($fileName, $option, $yamlFile);
        }

        return $result;
    }

    /**
     * Verify if there is a required key.
     *
     * @param  string[]  $foundationConfig
     * @param  string[]  $requiredKeys
     */
    protected function verifyKeys(array $foundationConfig, array $requiredKeys): void
    {
        foreach ($requiredKeys as $requiredKey) {
            if (! array_key_exists($requiredKey, $foundationConfig)) {
                throw new LogicException($requiredKey.' : Required key not specified.');
            }

            if ($foundationConfig[$requiredKey] === '') {
                throw new LogicException($requiredKey.' : The value is not set.');
            }

            if (is_array($foundationConfig[$requiredKey]) && empty($foundationConfig[$requiredKey])) {
                throw new LogicException($requiredKey.' : The value is not set.');
            }
        }
    }

    /**
     * Replace the string specified by @ with a different content.
     *
     * @param  string  $fileName
     * @param  string  $value
     * @param  mixed  $yamlFile
     * @return string
     */
    public function replaceAtSign(string $fileName, string $value, mixed $yamlFile): string
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
}
