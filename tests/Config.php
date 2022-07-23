<?php

declare(strict_types=1);

return [
    'foundations' => [
        'lump' => [
            // required
            'create_type'         => 'Lump',
            'read_path'           => __DIR__.'/Mock/Yaml',
            'output_path'         => __DIR__.'/Result/Lump/sample.php',
            'template_blade_file' => 'blueprint::lump',
            'is_override'         => true,

            // option
            'except_file_names'   => ['sample4'],
            'common_file_name'    => 'sample5',
            'options'             => [
                'sample' => '@fileName',
            ],
        ],

        'individual_not_read' => [
            // required
            'create_type'         => 'IndividualNotRead',
            'output_path'         => __DIR__.'/Result/IndividualNotRead/sample.php',
            'template_blade_file' => 'blueprint::individual_not_read',
            'is_override'         => true,

            // option
            'options'             => [
                'sample' => 'test',
            ],
        ],

        'individual' => [
            // required
            'create_type'             => 'Individual',
            'read_path'               => __DIR__.'/Mock/Yaml',
            'extension'               => 'php',
            'output_directory_path'   => __DIR__.'/Result/Individual',
            'template_blade_file'     => 'blueprint::individual',
            'is_override'             => true,

            // option
            'except_file_names'       => ['sample1', 'sample4', 'sample5'],
            'group_key_name'          => 'domain_group',
            'common_file_name'        => 'sample5',
            'options'                 => [
                'sample' => '@fileName\@groupName',
            ],
            'prefix'                  => 'Prefix',
            'suffix'                  => 'Suffix',
            'convert_class_name_type' => 'singular_studly',
        ],

        'group_lump_add_method' => [
            // required
            'create_type'             => 'GroupLumpAddMethod',
            'read_path'               => __DIR__.'/Mock/Yaml',
            'extension'               => 'php',
            'output_directory_path'   => __DIR__.'/Result/GroupLumpAddMethod',
            'template_blade_file'     => 'blueprint::group_lump_add_method',
            'group_key_name'          => 'domain_group',
            'method_key_name'         => 'api_name',
            'method_name_type'        => 'camel',
            'add_template_blade_file' => 'blueprint::add_method',

            // option
            'except_file_names'       => ['sample5'],
            'common_file_name'        => 'sample5',
            'options'                 => [
                'sample' => '@fileName\@groupName',
            ],
            'prefix'                  => 'Prefix',
            'suffix'                  => 'Suffix',
            'convert_class_name_type' => 'singular_studly',
        ],

        'group_lump' => [
            // required
            'create_type'             => 'GroupLump',
            'read_path'               => __DIR__.'/Mock/Yaml',
            'extension'               => 'php',
            'output_directory_path'   => __DIR__.'/Result/GroupLump',
            'template_blade_file'     => 'blueprint::group_lump',
            'group_key_name'          => 'domain_group',
            'is_override'             => true,

            // option
            'except_file_names'       => ['sample5'],
            'common_file_name'        => 'sample5',
            'options'                 => [
                'sample' => '@fileName\@groupName',
            ],
            'prefix'                  => 'Prefix',
            'suffix'                  => 'Suffix',
            'convert_class_name_type' => 'singular_studly',
        ],
    ],
];
