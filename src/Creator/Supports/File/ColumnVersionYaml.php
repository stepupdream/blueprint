<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports\File;

use LogicException;

class ColumnVersionYaml
{
    /**
     * @var bool
     */
    protected bool $isTargetVersionSelect;

    /**
     * @var string
     */
    protected string $targetVersion;

    /**
     * @var string[]
     */
    protected array $versionMatchColumns = [];

    /**
     * ColumnVersionYaml constructor.
     *
     * @param  string|null  $version
     * @param  mixed[]  $readYamlFile
     */
    public function __construct(
        ?string $version,
        protected array $readYamlFile
    ) {
        $this->isTargetVersionSelect = ! empty($version);
        $this->targetVersion = empty($version) ? '' : $version;
    }

    /**
     * Get isTargetVersionSelect.
     *
     * @return bool
     */
    public function isTargetVersionSelect(): bool
    {
        return $this->isTargetVersionSelect;
    }

    /**
     * Get targetVersion.
     *
     * @return string
     */
    public function targetVersion(): string
    {
        return $this->targetVersion;
    }

    /**
     * Get readYamlFile.
     *
     * @return mixed[]
     */
    public function readYamlFile(): array
    {
        return $this->readYamlFile;
    }

    /**
     * Set targetVersion.
     *
     * @param  string  $targetVersion
     */
    public function setTargetVersion(string $targetVersion): void
    {
        $this->targetVersion = $targetVersion;
    }

    /**
     * Get versionMatchColumns.
     *
     * @return string[]
     */
    public function versionMatchColumns(): array
    {
        return $this->versionMatchColumns;
    }

    /**
     * Get detailed information for columns with matching versions.
     *
     * @return mixed[]
     */
    public function versionMatchColumnDetail(): array
    {
        if (empty($this->targetVersion)) {
            throw new LogicException('This method cannot be called without a target Version specified.');
        }

        $columns = [];
        $afterColumn = '';
        foreach ($this->readYamlFile['columns'] as $column) {
            if ($afterColumn !== '') {
                $column['after_column'] = $afterColumn;
            }

            if ($column['version'] === $this->targetVersion) {
                $columns[] = $column;
            }
            $afterColumn = $column['name'];
        }

        return $columns;
    }

    /**
     * Add versionMatchColumns.
     *
     * @param  string  $version
     */
    public function addVersionMatchColumns(string $version): void
    {
        $this->versionMatchColumns[] = $version;
    }

    /**
     * Reset info.
     */
    public function resetVersionMatchColumns(): void
    {
        $this->versionMatchColumns = [];
    }
}
