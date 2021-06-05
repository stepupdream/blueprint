<?php

namespace StepUpDream\Blueprint\Test;

use StepUpDream\Blueprint\Foundation\Foundation;
use Symfony\Component\Yaml\Yaml;

/**
 * Class FoundationTest
 */
class FoundationTest extends TestCase
{
    /**
     * @test
     */
    public function replacedText(): void
    {
        $yamlFile = Yaml::parse(file_get_contents(__DIR__.'/Supports/TestFiles/sample.yml'));
        $foundationAttributes = [
            'output_directory_path'    => 'app/Http/Controllers/NewsWatchController/@groupName/@fileName',
            'extends_class_name'       => 'orange/@groupName/@fileName',
            'use_extends_class'        => 'orange/@groupName/@fileName',
            'interface_class_name'     => 'orange/@groupName/@fileName',
            'use_interface_class'      => 'orange/@groupName/@fileName',
            'request_directory_path'   => 'orange/@groupName/@fileName',
            'response_directory_path'  => 'orange/@groupName/@fileName',
            'options'                  => ['orange/@groupName/@fileName', 'banana'],
            'directory_group_key_name' => 'domain_group',
        ];

        $foundation = $this->app->make(Foundation::class, ['foundation' => $foundationAttributes]);
        $result = $foundation->replacedOutputDirectoryPath('apple', reset($yamlFile));
        self::assertEquals('app/Http/Controllers/NewsWatchController/Common/apple', $result);

        $result = $foundation->extendsClassNameForBlade('apple', reset($yamlFile));
        self::assertEquals(' extends orange/Common/apple', $result);

        $result = $foundation->useExtendsClassForBlade('apple', reset($yamlFile));
        self::assertEquals('use orange/Common/apple', $result);

        $result = $foundation->interfaceClassNameForBlade('apple', reset($yamlFile));
        self::assertEquals(' implements orange/Common/apple', $result);

        $result = $foundation->useInterfaceClassForBlade('apple', reset($yamlFile));
        self::assertEquals('use orange/Common/apple', $result);

        $result = $foundation->requestDirectoryPathForBlade('apple', reset($yamlFile));
        self::assertEquals('orange/Common/apple', $result);

        $result = $foundation->responseDirectoryPathForBlade('apple', reset($yamlFile));
        self::assertEquals('orange/Common/apple', $result);

        $result = $foundation->optionsForBlade('apple', reset($yamlFile));
        self::assertEquals(['orange/Common/apple', 'banana'], $result);
    }
}
