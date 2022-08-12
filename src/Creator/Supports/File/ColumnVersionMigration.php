<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports\File;

class ColumnVersionMigration
{
    /**
     * @var string[]
     */
    protected array $allColumnVersions = [];

    /**
     * Add columnVersion.
     *
     * @param  string[]  $columnVersions
     * @return void
     */
    public function addColumnVersions(array $columnVersions): void
    {
        foreach ($columnVersions as $columnName => $version) {
            $this->allColumnVersions[$columnName] = $version;
        }
    }

    /**
     * Get existing column names.
     *
     * @return string[]
     */
    public function existColumnNames(): array
    {
        return array_keys($this->allColumnVersions);
    }

    /**
     * Whether the migration file exists.
     *
     * @return bool
     */
    public function isExistMigrationFile(): bool
    {
        return ! empty($this->allColumnVersions);
    }

    /**
     * Get max targetVersion.
     *
     * @return string
     */
    public function maxTargetVersion(): string
    {
        $maxVersion = '';
        foreach ($this->allColumnVersions as $allColumnVersion) {
            if (empty($maxVersion)) {
                $maxVersion = $allColumnVersion;
                continue;
            }

            if ($maxVersion < $allColumnVersion) {
                $maxVersion = $allColumnVersion;
            }
        }

        return $maxVersion;
    }
}
