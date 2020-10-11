<?php

return [
    'create_classes' => [
        'api_base_controller' => [
            'create_type'         => 'IndividualWithoutRead',
            'template_blade_file' => 'foundation::Foundation.Controller.base',
            'output_path'         => app_path('Presentations/Http/Api/BaseController.php'),
            'extension'           => 'php',
            'use_extends_class'   => 'App\Presentations\Http\Controller;',
            'extends_class_name'  => 'Controller',
            'is_override'         => true,
        ],
        'api_controllers'     => [
            'create_type'             => 'GroupLumpWithAddMethod',
            'read_path'               => base_path('definition_document/Http/Api'),
            'except_file_names'       => ['Base'],
            'output_directory_path'   => app_path('Presentations/Http/Api/Controllers'),
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'suffix'                  => 'Controller',
            'group_key_name'          => 'controller_name',
            'method_key_name'         => 'name',
            'template_blade_file'     => 'foundation::Foundation.Controller.normal',
            'add_template_blade_file' => 'foundation::Component.Controller.add_method',
            'use_extends_class'       => 'App\Presentations\Http\Api\BaseController;',
            'extends_class_name'      => 'BaseController',
        ],
        'api_route'           => [
            'create_type'         => 'Lump',
            'read_path'           => base_path('definition_document/Http/Api'),
            'except_file_names'   => ['Base'],
            'output_path'         => base_path('routes/api.php'),
            'extension'           => 'php',
            'template_blade_file' => 'foundation::Foundation.Route.base',
            'is_override'         => true,
        ],
    ],

];
