<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Foundation;

use StepUpDream\Blueprint\Foundation\Supports\TextSupport;

/**
 * Class Foundation.
 */
class Foundation
{
    /**
     * @var string
     */
    protected $createType;

    /**
     * @var string
     */
    protected $readPath;

    /**
     * @var string
     */
    protected $outputPath;

    /**
     * @var string
     */
    protected $outputDirectoryPath;

    /**
     * @var string
     */
    protected $groupKeyName;

    /**
     * @var string
     */
    protected $methodKeyName;

    /**
     * @var string
     */
    protected $addTemplateBladeFile;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var string
     */
    protected $templateBladeFile;

    /**
     * @var bool
     */
    protected $isOverride;

    /**
     * @var string
     */
    protected $commonFileName;

    /**
     * @var array
     */
    protected $exceptFileNames;

    /**
     * @var string
     */
    protected $convertClassNameType;

    /**
     * @var string
     */
    protected $convertMethodNameType;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var string
     */
    protected $directoryGroupKeyName;

    /**
     * @var string
     */
    protected $extendsClassName;

    /**
     * @var string
     */
    protected $useExtendsClass;

    /**
     * @var string
     */
    protected $interfaceClassName;

    /**
     * @var string
     */
    protected $useInterfaceClass;

    /**
     * @var string
     */
    protected $requestDirectoryPath;

    /**
     * @var string
     */
    protected $responseDirectoryPath;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var \StepUpDream\Blueprint\Foundation\Supports\TextSupport
     */
    protected $textSupport;

    /**
     * Foundation constructor.
     *
     * @param  array  $foundation
     * @param  \StepUpDream\Blueprint\Foundation\Supports\TextSupport  $textSupport
     */
    public function __construct(
        array $foundation,
        TextSupport $textSupport
    ) {
        $this->createType = $foundation['create_type'] ?? '';
        $this->readPath = $foundation['read_path'] ?? '';
        $this->outputPath = $foundation['output_path'] ?? '';
        $this->outputDirectoryPath = $foundation['output_directory_path'] ?? '';
        $this->groupKeyName = $foundation['group_key_name'] ?? '';
        $this->methodKeyName = $foundation['method_key_name'] ?? '';
        $this->addTemplateBladeFile = $foundation['add_template_blade_file'] ?? '';
        $this->extension = $foundation['extension'] ?? '';
        $this->templateBladeFile = $foundation['template_blade_file'] ?? '';
        $this->isOverride = $foundation['is_override'] ?? false;

        $this->commonFileName = $foundation['common_file_name'] ?? '';
        $this->exceptFileNames = $foundation['except_file_names'] ?? [];
        $this->convertClassNameType = $foundation['convert_class_name_type'] ?? '';
        $this->convertMethodNameType = $foundation['convert_method_name_type'] ?? 'camel';
        $this->prefix = $foundation['prefix'] ?? '';
        $this->suffix = $foundation['suffix'] ?? '';
        $this->directoryGroupKeyName = $foundation['directory_group_key_name'] ?? '';
        $this->extendsClassName = $foundation['extends_class_name'] ?? '';
        $this->useExtendsClass = $foundation['use_extends_class'] ?? '';
        $this->interfaceClassName = $foundation['interface_class_name'] ?? '';
        $this->useInterfaceClass = $foundation['use_interface_class'] ?? '';
        $this->requestDirectoryPath = $foundation['request_directory_path'] ?? '';
        $this->responseDirectoryPath = $foundation['response_directory_path'] ?? '';
        $this->options = $foundation['options'] ?? [];
        $this->textSupport = $textSupport;
    }

    /**
     * @return string
     */
    public function createType(): string
    {
        return $this->createType;
    }

    /**
     * @return string
     */
    public function readPath(): string
    {
        return $this->readPath;
    }

    /**
     * @return string
     */
    public function outputPath(): string
    {
        return $this->outputPath;
    }

    /**
     * @return string
     */
    public function outputDirectoryPath(): string
    {
        return $this->outputDirectoryPath;
    }

    /**
     * Replaced output directory path.
     *
     * @param  mixed  $yamlFile
     * @param  string  $fileName
     * @return string
     */
    public function replacedOutputDirectoryPath(string $fileName, $yamlFile): string
    {
        return $this->replaceForBlade($fileName, $this->outputDirectoryPath, $yamlFile);
    }

    /**
     * @return string
     */
    public function groupKeyName(): string
    {
        return $this->groupKeyName;
    }

    /**
     * @return string
     */
    public function methodKeyName(): string
    {
        return $this->methodKeyName;
    }

    /**
     * @return string
     */
    public function addTemplateBladeFile(): string
    {
        return $this->addTemplateBladeFile;
    }

    /**
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function templateBladeFile(): string
    {
        return $this->templateBladeFile;
    }

    /**
     * @return bool
     */
    public function isOverride(): bool
    {
        return $this->isOverride;
    }

    /**
     * @return string
     */
    public function commonFileName(): string
    {
        return $this->commonFileName;
    }

    /**
     * @return array
     */
    public function exceptFileNames(): array
    {
        return $this->exceptFileNames;
    }

    /**
     * @return string
     */
    public function convertClassNameType(): string
    {
        return $this->convertClassNameType;
    }

    /**
     * @return string
     */
    public function convertMethodNameType(): string
    {
        return $this->convertMethodNameType;
    }

    /**
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function suffix(): string
    {
        return $this->suffix;
    }

    /**
     * @return string
     */
    public function directoryGroupKeyName(): string
    {
        return $this->directoryGroupKeyName;
    }

    /**
     * @return string
     */
    public function extendsClassName(): string
    {
        return $this->extendsClassName;
    }

    /**
     * @return string
     */
    public function useExtendsClass(): string
    {
        return $this->useExtendsClass;
    }

    /**
     * @return string
     */
    public function interfaceClassName(): string
    {
        return $this->interfaceClassName;
    }

    /**
     * @return string
     */
    public function useInterfaceClass(): string
    {
        return $this->useInterfaceClass;
    }

    /**
     * @return string
     */
    public function requestDirectoryPath(): string
    {
        return $this->requestDirectoryPath;
    }

    /**
     * @return string
     */
    public function responseDirectoryPath(): string
    {
        return $this->responseDirectoryPath;
    }

    /**
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Convert properties to arrays.
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * Replace key for replacement.
     *
     * @param  string  $fileName
     * @param $value
     * @param  mixed  $yamlFile
     * @return mixed
     */
    protected function replaceForBlade(string $fileName, $value, $yamlFile)
    {
        $groupName = $yamlFile[$this->directoryGroupKeyName()] ?? '';
        if (! empty($groupName) && strpos($value, '@groupName') !== false) {
            $value = str_replace('@groupName', $groupName, $value);
        }

        if (! empty($fileName) && strpos($value, '@fileName') !== false) {
            $value = str_replace('@fileName', $fileName, $value);
        }

        return $value;
    }

    /**
     * Extends class name for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return string
     */
    public function extendsClassNameForBlade(string $fileName, $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->extendsClassName, $yamlFile);

        return empty($replacedValue) ? '' : ' extends '.$replacedValue;
    }

    /**
     * Use extends class for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return string
     */
    public function useExtendsClassForBlade(string $fileName, $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->useExtendsClass, $yamlFile);

        return empty($replacedValue) ? '' : 'use '.$replacedValue;
    }

    /**
     * Interface class name for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return string
     */
    public function interfaceClassNameForBlade(string $fileName, $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->interfaceClassName, $yamlFile);

        return empty($replacedValue) ? '' : ' implements '.$replacedValue;
    }

    /**
     * Interface class name for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return string
     */
    public function useInterfaceClassForBlade(string $fileName, $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->useInterfaceClass, $yamlFile);

        return empty($replacedValue) ? '' : 'use '.$replacedValue;
    }

    /**
     * Request directory path for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return string
     */
    public function requestDirectoryPathForBlade(string $fileName, $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->requestDirectoryPath, $yamlFile);

        return empty($replacedValue) ? '' : $replacedValue;
    }

    /**
     * Response directory path for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return string
     */
    public function responseDirectoryPathForBlade(string $fileName, $yamlFile = null): string
    {
        $replacedValue = $this->replaceForBlade($fileName, $this->responseDirectoryPath, $yamlFile);

        return empty($replacedValue) ? '' : $replacedValue;
    }

    /**
     * options for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return array
     */
    public function optionsForBlade(string $fileName, $yamlFile = null): array
    {
        $result = [];
        foreach ($this->options as $option) {
            $result[] = $this->replaceForBlade($fileName, $option, $yamlFile);
        }

        return $result;
    }
}
