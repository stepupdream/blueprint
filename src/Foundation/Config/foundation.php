<?php

return [
    'create_classes' => [
        'api_base_controller'    => [
            'create_type'         => 'IndividualWithoutRead',
            'template_blade_file' => 'foundation::Foundation.Controller.base',
            'output_path'         => app_path('Presentations/Http/Api/BaseController.php'),
            'extension'           => 'php',
            'use_extends_class'   => 'App\Presentations\Http\Controller;',
            'extends_class_name'  => 'Controller',
            'is_override'         => true,
        ],
        'api_controllers'        => [
            'create_type'             => 'GroupLumpWithAddMethod',
            'read_path'               => base_path('definition_document/http/api'),
            'except_file_names'       => ['Base'],
            'output_directory_path'   => app_path('Presentations/Http/Api/Controllers'),
            'extension'               => 'php',
            'suffix'                  => 'Controller',
            'group_key_name'          => 'controller_name',
            'method_key_name'         => 'name',
            'template_blade_file'     => 'foundation::Foundation.Controller.normal',
            'add_template_blade_file' => 'foundation::Component.Controller.add_method',
            'use_extends_class'       => 'App\Presentations\Http\Api\BaseController;',
            'extends_class_name'      => 'BaseController',
            'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
            'response_directory_path' => 'App\Presentations\Http\Api\Responses',
        ],
        'api_route'              => [
            'create_type'         => 'Lump',
            'read_path'           => base_path('definition_document/http/api'),
            'except_file_names'   => ['Base'],
            'output_path'         => base_path('routes/api.php'),
            'extension'           => 'php',
            'template_blade_file' => 'foundation::Foundation.Route.base',
            'is_override'         => true,
        ],
        
        // Application
        'api_applications'     => [
            'create_type'             => 'GroupLumpWithAddMethod',
            'read_path'               => base_path('definition_document/http/api'),
            'except_file_names'       => ['Base'],
            'output_directory_path'   => app_path('Applications'),
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'suffix'                  => 'Application',
            'group_key_name'          => 'controller_name',
            'method_key_name'         => 'name',
            'template_blade_file'     => 'foundation::Foundation.Application.base',
            'add_template_blade_file' => 'foundation::Component.Application.add_method',
        ],
        
        // User
        'user_models' => [
            'create_type'             => 'Individual',
            'read_path'               => base_path('definition_document/database/user_data'),
            'except_file_names'       => [],
            'output_directory_path'   => app_path('Infrastructures/User') . '/%s',
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'template_blade_file'     => 'foundation::Foundation.Model.normal',
            'use_extends_class'       => 'App\Infrastructures\User\%s\Framework\%s as Framework;',
            'extends_class_name'      => 'Framework',
            'is_override'             => false,
        ],
        
        'user_models_framework' => [
            'create_type'             => 'Individual',
            'read_path'               => base_path('definition_document/database/user_Data'),
            'except_file_names'       => [],
            'output_directory_path'   => app_path('Infrastructures/User') . '/%s/Framework',
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'template_blade_file'     => 'foundation::Foundation.Model.framework',
            'is_override'             => true,
        ],
        
        'user_models_base'  => [
            'create_type'         => 'IndividualWithoutRead',
            'template_blade_file' => 'foundation::Foundation.Model.base',
            'output_path'         => app_path('Infrastructures/User/BaseUser.php'),
            'extension'           => 'php',
            'is_override'         => false,
        ],
    ],
];
