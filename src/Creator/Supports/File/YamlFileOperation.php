<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports\File;

use LogicException;
use StepUpDream\DreamAbilitySupport\Supports\File\YamlFileOperation as BaseYamlFileOperation;

class YamlFileOperation extends BaseYamlFileOperation
{
    /**
     * Read the version for each column.
     *
     * @param  string  $directoryPath
     * @param  string  $findFileName
     * @param  string|null  $version
     * @return ColumnVersionYaml
     */
    public function readColumnVersionByFileName(
        string $directoryPath,
        string $findFileName,
        ?string $version
    ): ColumnVersionYaml {
        $readYamlFile = $this->readByFileName($directoryPath, $findFileName);
        if (empty($readYamlFile) || empty($readYamlFile['columns'])) {
            throw new LogicException('Failed to load Yaml file. : '.$directoryPath.' -> '.$findFileName);
        }

        $columnVersion = new ColumnVersionYaml($version, $readYamlFile);
        foreach ($readYamlFile['columns'] as $column) {
            if (empty($column['version']) || empty($column['name'])) {
                throw new LogicException('Missing required key [name, version] : '.$directoryPath.' -> '.$findFileName);
            }

            // Returns the highest version if no target version is specified.
            if (empty($columnVersion->targetVersion()) ||
                (! $columnVersion->isTargetVersionSelect() && $columnVersion->targetVersion() < $column['version'])) {
                $columnVersion->resetVersionMatchColumns();
                $columnVersion->setTargetVersion($column['version']);
            }

            if ($columnVersion->targetVersion() === $column['version']) {
                $columnVersion->addVersionMatchColumns($column['name']);
            }
        }

        return $columnVersion;
    }
}
