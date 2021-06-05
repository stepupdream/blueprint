<?php

return [
    'create_classes' => [
        'api_base_controller' => [
            'create_type'         => 'IndividualWithoutRead',
            'template_blade_file' => 'blueprint::Foundation.Controller.base',
            'output_path'         => app_path('Presentations/Http/Api/BaseController.php'),
            'extension'           => 'php',
            'use_extends_class'   => 'App\Http\Controllers\Controller;',
            'extends_class_name'  => 'Controller',
            'is_override'         => false,
        ],

        'api_controller' => [
            'create_type'             => 'GroupLumpWithAddMethod',
            'read_path'               => base_path('definition_document/http/api'),
            'except_file_names'       => ['Base'],
            'output_directory_path'   => app_path('Presentations/Http/Api/Controllers'),
            'extension'               => 'php',
            'suffix'                  => 'Controller',
            'group_key_name'          => 'controller_name',
            'method_key_name'         => 'name',
            'template_blade_file'     => 'blueprint::Foundation.Controller.normal',
            'add_template_blade_file' => 'blueprint::Component.Controller.add_method',
            'use_extends_class'       => 'App\Presentations\Http\Api\BaseController;',
            'extends_class_name'      => 'BaseController',
            'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
            'response_directory_path' => 'App\Presentations\Http\Api\Responses',
        ],

        'api_route' => [
            'create_type'         => 'Lump',
            'read_path'           => base_path('definition_document/http/api'),
            'except_file_names'   => ['Base'],
            'output_path'         => base_path('routes/api.php'),
            'extension'           => 'php',
            'template_blade_file' => 'blueprint::Foundation.Route.base',
            'is_override'         => true,
        ],

        'user_model' => [
            'create_type'             => 'Individual',
            'read_path'               => base_path('definition_document/database/user'),
            'except_file_names'       => [],
            'output_directory_path'   => app_path('Infrastructures/User').'/@fileName',
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'template_blade_file'     => 'blueprint::Foundation.Model.normal',
            'use_extends_class'       => 'App\Infrastructures\User\@fileName\Blueprint\@fileName as Blueprint;',
            'extends_class_name'      => 'Blueprint',
            'is_override'             => false,
        ],

        'user_models_blueprint' => [
            'create_type'             => 'Individual',
            'read_path'               => base_path('definition_document/database/user'),
            'except_file_names'       => [],
            'output_directory_path'   => app_path('Infrastructures/User').'/@fileName/Blueprint',
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'template_blade_file'     => 'blueprint::Foundation.Model.blueprint',
            'use_extends_class'       => 'App\Infrastructures\User\BaseUser;',
            'extends_class_name'      => 'BaseUser',
            'is_override'             => true,
        ],

        'user_models_base' => [
            'create_type'         => 'IndividualWithoutRead',
            'template_blade_file' => 'blueprint::Foundation.Model.base',
            'output_path'         => app_path('Infrastructures/User/BaseUser.php'),
            'extension'           => 'php',
            'is_override'         => false,
        ],

        'migration' => [
            'create_type'             => 'Individual',
            'read_path'               => base_path('definition_document/database'),
            'except_file_names'       => [],
            'output_directory_path'   => database_path('temp'),
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'template_blade_file'     => 'blueprint::Foundation.Migration.base',
            'is_override'             => true,
            'option'                  => '',
        ],
    ],
];
