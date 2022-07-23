<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use LogicException;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;

abstract class Base implements BaseInterface
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
