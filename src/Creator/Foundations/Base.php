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
    protected string $extension;

    /**
     * @var string
     */
    protected string $templateBladeFile;

    /**
     * @var string
     */
    protected string $extendsClassName;

    /**
     * @var string
     */
    protected string $useExtendsClass;

    /**
     * @var string
     */
    protected string $interfaceClassName;

    /**
     * @var string
     */
    protected string $useInterfaceClass;

    /**
     * @var string
     */
    protected string $requestDirectoryPath;

    /**
     * @var string
     */
    protected string $responseDirectoryPath;

    /**
     * @var string[]
     */
    protected array $options;

    /**
     * @var string
     */
    protected string $directoryGroupKeyName;

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
        // required
        $this->extension = (string) $foundationConfig['extension'];
        $this->templateBladeFile = (string) $foundationConfig['template_blade_file'];

        // option
        $this->useExtendsClass = $foundationConfig['use_extends_class'] ?? '';
        $this->interfaceClassName = $foundationConfig['interface_class_name'] ?? '';
        $this->useInterfaceClass = $foundationConfig['use_interface_class'] ?? '';
        $this->extendsClassName = $foundationConfig['extends_class_name'] ?? '';
        $this->requestDirectoryPath = $foundationConfig['request_directory_path'] ?? '';
        $this->responseDirectoryPath = $foundationConfig['response_directory_path'] ?? '';
        $this->options = $foundationConfig['options'] ?? [];
        $this->directoryGroupKeyName = $foundationConfig['directory_group_key_name'] ?? '';
    }

    /**
     * Extends class name for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return string
     */
    public function extendsClassNameForBlade(string $fileName, mixed $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->extendsClassName, $yamlFile);

        return empty($replacedValue) ? '' : ' extends '.$replacedValue;
    }

    /**
     * Replace key for replacement.
     *
     * @param  string  $fileName
     * @param  string  $value
     * @param  mixed  $yamlFile
     * @return string
     */
    protected function replaceForBlade(string $fileName, string $value, mixed $yamlFile): string
    {
        $groupName = $yamlFile[$this->directoryGroupKeyName] ?? '';
        if (! empty($groupName) && str_contains($value, '@groupName')) {
            $value = str_replace('@groupName', $groupName, $value);
        }

        if (! empty($fileName) && str_contains($value, '@fileName')) {
            $value = str_replace('@fileName', $fileName, $value);
        }

        return $value;
    }

    /**
     * Use extends class for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return string
     */
    public function useExtendsClassForBlade(string $fileName, mixed $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->useExtendsClass, $yamlFile);

        return empty($replacedValue) ? '' : 'use '.$replacedValue;
    }

    /**
     * Interface class name for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return string
     */
    public function interfaceClassNameForBlade(string $fileName, mixed $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->interfaceClassName, $yamlFile);

        return empty($replacedValue) ? '' : ' implements '.$replacedValue;
    }

    /**
     * Interface class name for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return string
     */
    public function useInterfaceClassForBlade(string $fileName, mixed $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->useInterfaceClass, $yamlFile);

        return empty($replacedValue) ? '' : 'use '.$replacedValue;
    }

    /**
     * Request directory path for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return string
     */
    public function requestDirectoryPathForBlade(string $fileName, mixed $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->requestDirectoryPath, $yamlFile);

        return empty($replacedValue) ? '' : $replacedValue;
    }

    /**
     * Response directory path for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return string
     */
    public function responseDirectoryPathForBlade(string $fileName, mixed $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->responseDirectoryPath, $yamlFile);

        return empty($replacedValue) ? '' : $replacedValue;
    }

    /**
     * options for blade.
     *
     * @param  string  $fileName
     * @param  mixed|null  $yamlFile
     * @return mixed[]
     */
    public function optionsForBlade(string $fileName, mixed $yamlFile = null): array
    {
        $result = [];
        foreach ($this->options as $option) {
            $result[] = $this->replaceForBlade($fileName, $option, $yamlFile);
        }

        return $result;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
    }

    /**
     * Get templateBladeFile
     *
     * @return string
     */
    public function templateBladeFile(): string
    {
        return $this->templateBladeFile;
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
}
