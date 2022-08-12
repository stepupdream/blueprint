<?php

declare(strict_types=1);

// This is a sample. This may change with library updates.
// Please change the output destination etc. according to your own project rules.
// Please change the contents of the template blade file according to the project.
return [
    'foundations' => [
        'api_base_controller' => [
            'create_type'         => 'IndividualNotRead',
            'template_blade_file' => 'blueprint::Foundation.Controller.base',
            'output_path'         => app_path('Presentations/Http/Api/BaseController.php'),
            'is_override'         => false,
            'options'             => [
                'use_extends_class'  => 'use App\Http\Controllers\Controller;',
                'extends_class_name' => ' extends Controller',
            ],
        ],

        'api_controller' => [
            'create_type'             => 'GroupLumpAddMethod',
            'read_path'               => base_path('definition_document/http/api'),
            'except_file_names'       => ['Base'],
            'output_directory_path'   => app_path('Presentations/Http/Api/Controllers'),
            'extension'               => 'php',
            'suffix'                  => 'Controller',
            'group_key_name'          => 'controller_name',
            'method_key_name'         => 'name',
            'method_name_type'        => 'camel',
            'template_blade_file'     => 'blueprint::Foundation.Controller.normal',
            'add_template_blade_file' => 'blueprint::Component.Controller.add_method',
            'options'                 => [
                'use_extends_class'       => 'use App\Presentations\Http\Api\BaseController;',
                'extends_class_name'      => ' extends BaseController',
                'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
                'response_directory_path' => 'App\Presentations\Http\Api\Responses',
            ],
        ],

        'api_controller2' => [
            'create_type'           => 'GroupLump',
            'read_path'             => base_path('definition_document/http/api'),
            'except_file_names'     => ['Base'],
            'output_directory_path' => app_path('Presentations/Http/Api2/Controllers'),
            'group_key_name'        => 'controller_name',
            'extension'             => 'php',
            'template_blade_file'   => 'blueprint::Foundation.Controller.normal2',
            'is_override'           => true,
            'suffix'                => 'Controller',
            'options'               => [
                'use_extends_class'  => 'use App\Presentations\Http\Api\BaseController;',
                'extends_class_name' => ' extends BaseController',
            ],
        ],

        'api_route' => [
            'create_type'         => 'Lump',
            'read_path'           => base_path('definition_document/http/api'),
            'except_file_names'   => ['Base'],
            'output_path'         => base_path('routes/api.php'),
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
            'is_override'             => false,
            'options'                 => [
                'use_extends_class'  => 'use App\Infrastructures\User\@fileName\Blueprint\@fileName as Blueprint;',
                'extends_class_name' => ' extends Blueprint',
            ],
        ],

        'user_models_blueprint' => [
            'create_type'             => 'Individual',
            'read_path'               => base_path('definition_document/database/user'),
            'except_file_names'       => [],
            'output_directory_path'   => app_path('Infrastructures/User').'/@fileName/Blueprint',
            'convert_class_name_type' => 'singular_studly',
            'extension'               => 'php',
            'template_blade_file'     => 'blueprint::Foundation.Model.blueprint',
            'is_override'             => true,
            'options'                 => [
                'use_extends_class'  => 'use App\Infrastructures\User\BaseUser;',
                'extends_class_name' => ' extends BaseUser',
            ],
        ],

        'user_models_base' => [
            'create_type'         => 'IndividualNotRead',
            'template_blade_file' => 'blueprint::Foundation.Model.base',
            'output_path'         => app_path('Infrastructures/User/BaseUser.php'),
            'is_override'         => false,
            'options'             => [
                'use_extends_class'  => '',
                'extends_class_name' => '',
            ],
        ],
    ],
    'foundations_migration' => [
        'user_db' => [
            'read_path'                  => base_path('definition_document/database/user'),
            'except_file_names'          => [],
            'output_directory_path'      => database_path('migrations/step_up_dream'),
            'template_blade_file'        => 'blueprint::Foundation.Migration.create',
            'template_update_blade_file' => 'blueprint::Foundation.Migration.update',
            'options'                    => [
                'connection' => 'user_db',
            ],
        ],
    ],
];
