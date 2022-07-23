<?php

namespace StepUpDream\Blueprint\Test\Creators;

use LogicException;
use StepUpDream\Blueprint\Foundation\Creators\BaseCreator;
use StepUpDream\Blueprint\Foundation\Supports\YamlFileOperation;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class BaseCreatorTest
 *
 * @package StepUpDream\Blueprint\Test\Supports
 */
class BaseCreatorTest extends TestCase
{
    public function testConvertFileFullPathToNamespace(): void
    {
        /* @see BaseCreator::convertFileFullPathToNamespace */
        $response = $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'convertFileFullPathToNamespace',
            ['App/Presentations/Http/Api/BaseController.php']
        );
        $testResult = 'App\Presentations\Http\Api';
        
        self::assertEquals($response, $testResult);
    }
    
    public function testConvertFileFullPathToClassPath(): void
    {
        /* @see BaseCreator::convertFileFullPathToClassPath */
        $response = $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'convertFileFullPathToClassPath',
            ['App/Presentations/Http/Api/BaseController.php']
        );
        $testResult = 'App\Presentations\Http\Api\BaseController';
        
        self::assertEquals($response, $testResult);
    }
    
    public function testConvertClassFilePath1(): void
    {
        $foundation = [
            'directory_group_key_name' => 'controller_name',
            'output_directory_path'    => app_path('Presentations/Http/Api/Requests/%g').'/%s',
            'convert_class_name_type'  => 'singular_studly',
            'extension'                => 'php',
            'prefix'                   => 'Test',
            'suffix'                   => 'Request',
        ];
        
        $yamlFileOperation = $this->app->make(YamlFileOperation::class);
        $readYamlFiles = $yamlFileOperation->readByDirectoryPath(__DIR__.'/TestFiles/Yaml/Temp');
        $readYamlFile = reset($readYamlFiles);
        
        /* @see BaseCreator::convertClassFilePath */
        $response = $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'convertClassFilePath',
            [$foundation, 'Get', $readYamlFile]
        );
        $testResult = $this->app->path().'/Presentations/Http/Api/Requests/User/Get/TestGetRequest.php';
        
        self::assertEquals($response, $testResult);
    }
    
    public function testReadCommonYamlFile(): void
    {
        $foundation = [
            'common_file_name' => 'Base',
            'read_path'        => __DIR__.'/TestFiles/Yaml/Temp',
        ];
        
        /* @see BaseCreator::readCommonYamlFile */
        $response = $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'readCommonYamlFile',
            [$foundation]
        );
        
        $testResult = [
            'controller_name' => 'User',
            'route_prefix'    => 'api',
            'http_method'     => 'Post',
            'name'            => 'Base',
            'description'     => 'get user data',
            'request'         => [
                'columns' => null
            ],
            'response'        => [
                'columns' => [
                    [
                        'name'        => 'user',
                        'description' => 'user data',
                        'data_type'   => 'User.User',
                    ]
                ]
            ]
        ];
        
        self::assertEquals($response, $testResult);
    }
    
    public function testReadYamlFile(): void
    {
        $foundation = [
            'except_file_names' => ['Get'],
            'read_path'         => __DIR__.'/TestFiles/Yaml/Temp',
        ];
        
        /* @see BaseCreator::readYamlFile */
        $response = $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'readYamlFile',
            [$foundation]
        );
        
        $testResult = [
            '/work/packages/stepupdream/blueprint/tests/Creators/TestFiles/Yaml/Temp/Base.yml' => [
                'controller_name' => 'User',
                'route_prefix'    => 'api',
                'http_method'     => 'Post',
                'name'            => 'Base',
                'description'     => 'get user data',
                'request'         => [
                    'columns' => null
                ],
                'response'        => [
                    'columns' => [
                        [
                            'name'        => 'user',
                            'description' => 'user data',
                            'data_type'   => 'User.User',
                        ]
                    ]
                ]
            ]
        ];
        
        self::assertEquals($response, $testResult);
    }
    
    public function testVerifyKeys(): void
    {
        $this->expectException(LogicException::class);
        $foundation = [
            'except_file_names' => ['Get'],
            'read_path'         => __DIR__.'/TestFiles/Yaml/Temp',
        ];
        
        /* @see BaseCreator::verifyKeys */
        $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'verifyKeys',
            [$foundation, ['requiredKey']]
        );
        
        /* @see BaseCreator::verifyKeys */
        $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'verifyKeys',
            [$foundation, ['requiredKey'], ['except_file_names']]
        );
    }
}
