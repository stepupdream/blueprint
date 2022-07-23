<?php

declare(strict_types=1);

return [
    'foundations' => [
        'lump' => [
            // required
            'create_type'         => 'Lump',
            'read_path'           => __DIR__.'/Mock/Yaml/Lump',
            'output_path'         => __DIR__.'/Result/Lump/sample.php',
            'template_blade_file' => 'blueprint::lump',
            'is_override'         => true,

            // option
            'except_file_names'   => ['Get3', 'Get4'],
            'group_key_name'      => 'domain_group',
            'common_file_name'    => 'Get4',
            'options'             => [
                'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
                'response_directory_path' => 'App\Presentations\Http\Api\Responses',
                'use_extends_class'       => 'use App\Infrastructures\User\@fileName\@groupName\CCC as Blueprint;',
                'extends_class_name'      => 'extends Blueprint',
                'use_interface_class'     => 'use App\Infrastructures\User\@fileName\@groupName\DDD as Blueprint2;',
                'interface_class_name'    => 'implements Blueprint2',
            ],
        ],

        'individual_not_read' => [
            // required
            'create_type'         => 'IndividualNotRead',
            'output_path'         => __DIR__.'/Result/IndividualNotRead/sample.php',
            'template_blade_file' => 'blueprint::individual_not_read',
            'is_override'         => true,

            // option
            'except_file_names'   => ['Get3', 'Get4'],
            'group_key_name'      => 'domain_group',
            'common_file_name'    => 'Get4',
            'options'             => [
                'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
                'response_directory_path' => 'App\Presentations\Http\Api\Responses',
                'use_extends_class'       => 'use App\Infrastructures\User\@fileName\@groupName\CCC as Blueprint;',
                'extends_class_name'      => 'extends Blueprint',
                'use_interface_class'     => 'use App\Infrastructures\User\@fileName\@groupName\DDD as Blueprint2;',
                'interface_class_name'    => 'implements Blueprint2',
            ],
        ],

        'individual' => [
            // required
            'create_type'             => 'Individual',
            'read_path'               => __DIR__.'/Mock/Yaml/Individual',
            'extension'               => 'php',
            'output_directory_path'   => __DIR__.'/Result/Individual',
            'template_blade_file'     => 'blueprint::individual',
            'is_override'             => true,

            // option
            'except_file_names'       => ['common'],
            'group_key_name'          => 'domain_group',
            'common_file_name'        => 'common',
            'options'                 => [
                'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
                'response_directory_path' => 'App\Presentations\Http\Api\Responses',
                'use_extends_class'       => 'use App\Infrastructures\User\@fileName\@groupName\CCC as Blueprint;',
                'extends_class_name'      => 'extends Blueprint',
                'use_interface_class'     => 'use App\Infrastructures\User\@fileName\@groupName\DDD as Blueprint2;',
                'interface_class_name'    => 'implements Blueprint2',
            ],
            'prefix'                  => 'Prefix',
            'suffix'                  => 'Suffix',
            'convert_class_name_type' => 'singular_studly',
        ],

        'group_lump_add_method' => [
            // required
            'create_type'             => 'GroupLumpAddMethod',
            'read_path'               => __DIR__.'/Mock/Yaml/GroupLumpAddMethod',
            'extension'               => 'php',
            'output_directory_path'   => __DIR__.'/Result/GroupLumpAddMethod',
            'template_blade_file'     => 'blueprint::group_lump_add_method',
            'group_key_name'          => 'domain_group',
            'method_key_name'         => 'name',
            'method_name_type'        => 'camel',
            'add_template_blade_file' => 'blueprint::add_method',

            // option
            'except_file_names'       => ['Get3'],
            'common_file_name'        => 'Get3',
            'options'                 => [
                'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
                'response_directory_path' => 'App\Presentations\Http\Api\Responses',
                'use_extends_class'       => 'use App\Infrastructures\User\@fileName\@groupName\CCC as Blueprint;',
                'extends_class_name'      => 'extends Blueprint',
                'use_interface_class'     => 'use App\Infrastructures\User\@fileName\@groupName\DDD as Blueprint2;',
                'interface_class_name'    => 'implements Blueprint2',
            ],
            'prefix'                  => 'Prefix',
            'suffix'                  => 'Suffix',
            'convert_class_name_type' => 'singular_studly',
        ],

        'group_lump' => [
            // required
            'create_type'             => 'GroupLump',
            'read_path'               => __DIR__.'/Mock/Yaml/GroupLump',
            'extension'               => 'php',
            'output_directory_path'   => __DIR__.'/Result/GroupLump',
            'template_blade_file'     => 'blueprint::group_lump',
            'group_key_name'          => 'domain_group',
            'is_override'             => true,

            // option
            'except_file_names'       => ['Get4'],
            'common_file_name'        => 'Get4',
            'options'                 => [
                'request_directory_path'  => 'App\Presentations\Http\Api\Requests',
                'response_directory_path' => 'App\Presentations\Http\Api\Responses',
                'use_extends_class'       => 'use App\Infrastructures\User\@fileName\@groupName\CCC as Blueprint;',
                'extends_class_name'      => 'extends Blueprint',
                'use_interface_class'     => 'use App\Infrastructures\User\@fileName\@groupName\DDD as Blueprint2;',
                'interface_class_name'    => 'implements Blueprint2',
            ],
            'prefix'                  => 'Prefix',
            'suffix'                  => 'Suffix',
            'convert_class_name_type' => 'singular_studly',
        ],
    ],
];
