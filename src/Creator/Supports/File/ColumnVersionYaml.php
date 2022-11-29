<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports\File;

use LogicException;

class ColumnVersionYaml
{
    /**
     * @var string
     */
    protected string $maxVersion = '';

    /**
     * @var string[]
     */
    protected array $versionMatchColumns = [];

    /**
     * ColumnVersionYaml constructor.
     *
     * @param  mixed[]  $readYamlFile
     */
    public function __construct(
        protected array $readYamlFile
    ) {
    }

    /**
     * Get maxVersion.
     *
     * @return string
     */
    public function maxVersion(): string
    {
        return $this->maxVersion;
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
     * Set MaxVersion.
     *
     * @param  string  $maxVersion
     */
    public function setMaxVersion(string $maxVersion): void
    {
        $this->maxVersion = $maxVersion;
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
        if (empty($this->maxVersion)) {
            throw new LogicException('This method cannot be called without a target Version specified.');
        }

        $columns = [];
        $afterColumn = '';
        foreach ($this->readYamlFile['columns'] as $column) {
            if ($afterColumn !== '') {
                $column['after_column'] = $afterColumn;
            }

            if ($column['version'] === $this->maxVersion) {
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
