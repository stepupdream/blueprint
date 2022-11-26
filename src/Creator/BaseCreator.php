<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\LineMessage;

abstract class BaseCreator extends LineMessage
{
    /**
     * BaseCreator constructor.
     *
     * @param  \StepUpDream\Blueprint\Creator\Supports\File\FileOperation  $fileCreator
     * @param  \StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation  $yamlReader
     * @param  \StepUpDream\Blueprint\Creator\Supports\TextSupport  $textSupport
     */
    public function __construct(
        protected FileOperation $fileCreator,
        protected YamlFileOperation $yamlReader,
        protected TextSupport $textSupport
    ) {
    }
}
