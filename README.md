# blueprint
[![Laravel 6|7|8](https://img.shields.io/badge/Laravel-6|7|8-orange.svg)](http://laravel.com)
[![License](https://poser.pugx.org/stepupdream/blueprint/license)](//packagist.org/packages/stepupdream/blueprint)

## Introduction

blueprint is an open source tool that provides commands to automatically generate class templates from yaml files.

## Features

When developing a large project, it is better to divide the class into small pieces.  
However, it takes time for humans to create them one by one, and they are not unified.  
By using this package, you will be freed from the hassle of creating classes.  
Use the Blade template used in Laravel to create a template for your class.
It can be freely adjusted to suit your project.

## Requirements 
The requirements to Blueprint application is:
- PHP - Supported Versions: >= 8.0
- Laravel - Supported Versions: >= 8.0

## Installation 
Require this package with composer using the following command:

```bash 
composer require --dev stepupdream/blueprint
```

## Usage
1. You can publish the config file (php artisan vendor:publish)
2. Feel free to modify the config file and template blade file

## Run Locally

```bash
php artisan blueprint:foundation-create
```

## Output Pattern

Currently, there are 5 output patterns.

- Lump  
Generates one file from yaml files in the specified directory.

- Individual  
Reads the yaml file in the specified directory and creates one file for each yaml file.  
The most orthodox pattern.

- IndividualWithoutRead  
A pattern that does not read yaml.  
Create a file in a format similar to the conventional Laravel stub.

- GroupLumpWithAddMethod  
Reads yaml files in the specified directory and creates files in groups.  
If the method is undefined in the same file, add only the undefined method.

- GroupLumpFileCreator  
Reads yaml files in the specified directory, organizes them in groups,  
and outputs them to a file.
  
## Config
Required keys are determined by each pattern.  
There is no problem if you do not enter any keys other than the required keys. It will be an invalid value.  
You can use two special characters in config: @fileName and @groupName.  
If you specify these strings, the strings will be replaced automatically.

|  name  |  type  |  detail  |
| ---- | ---- | ---- |
|  create_type  | string |  Output pattern  |
|  read_path  | string |  Directory path where yaml files are located  |
|  except_file_names  | array |  List of file names that you want to exclude from reading  |
|  output_path  | string |  Output destination path  |
|  output_directory_path  | string |  Output destination path  |
|  extension  | string |  Output file extension  |
|  group_key_name  | string |  Those with the same specified key value can be grouped together  |
|  method_key_name  | string |  Key used for method name when adding method  |
|  template_blade_file  | string |  Blade file that serves as a template  |
|  add_template_blade_file  | string |  Blade file that serves as a template  |
|  use_extends_class  | string |  String to pass to template  |
|  extends_class_name  | string |  String to pass to template  |
|  request_directory_path  | string |  String to pass to template  |
|  response_directory_path  | string |  String to pass to template  |
|  common_file_name  | string |  What to pass to the blade file as a common yaml  |
|  convert_class_name_type  | string |  You can change the class name to any type  |
|  convert_method_name_type  | string |  You can change the method name you add to any type  |
|  prefix  | string |  The string you want to add to the start of the output file  |
|  suffix  | string |  The string you want to add to the end of the output file  |
|  directory_group_key_name  | string |  Used to replace the special character @groupName that can be used in config  |
|  options  | array |  A list of values you want to pass to the blade file as optional values, separate from the contents of the yaml file  |
|  is_override  | bool |  Whether it is okay to overwrite the file when outputting the file  |

## Sample
#### Required key for Lump Pattern

|  name  |  type  |  detail  |
| ---- | ---- | ---- |
|  create_type  | string |  Output pattern  |
|  read_path  | string |  Directory path where yaml files are located  |
|  output_path  | string |  Output destination path  |
|  template_blade_file  | string |  Blade file that serves as a template  |
|  is_override  | bool |  Whether it is okay to overwrite the file when outputting the file  |

```php
[
    'api_route' => [
        'create_type'         => 'Lump',
        'read_path'           => base_path('definition_document/http/api'),
        'except_file_names'   => ['Base'],
        'output_path'         => base_path('routes/api.php'),
        'template_blade_file' => 'blueprint::Foundation.Route.base',
        'is_override'         => true,
    ]
];
```

#### Required key for Individual Pattern

|  name  |  type  |  detail  |
| ---- | ---- | ---- |
|  create_type  | string |  Output pattern  |
|  read_path  | string |  Directory path where yaml files are located  |
|  output_directory_path  | string |  Output destination path  |
|  extension  | string |  Output file extension  |
|  template_blade_file  | string |  Blade file that serves as a template  |
|  is_override  | bool |  Whether it is okay to overwrite the file when outputting the file  |

```php
[
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
];
```

#### Required key for IndividualWithoutRead Pattern

|  name  |  type  |  detail  |
| ---- | ---- | ---- |
|  create_type  | string |  Output pattern  |
|  output_path  | string |  Output destination path  |
|  template_blade_file  | string |  Blade file that serves as a template  |
|  is_override  | bool |  Whether it is okay to overwrite the file when outputting the file  |

```php
[
    'create_type'         => 'IndividualWithoutRead',
    'template_blade_file' => 'blueprint::Foundation.Controller.base',
    'output_path'         => app_path('Presentations/Http/Api/BaseController.php'),
    'use_extends_class'   => 'App\Http\Controllers\Controller;',
    'extends_class_name'  => 'Controller',
    'is_override'         => false,
];
```

#### Required key for GroupLumpWithAddMethod Pattern

|  name  |  type  |  detail  |
| ---- | ---- | ---- |
|  create_type  | string |  Output pattern  |
|  read_path  | string |  Directory path where yaml files are located  |
|  output_directory_path  | string |  Output destination path  |
|  extension  | string |  Output file extension  |
|  method_key_name  | string |  Key used for method name when adding method  |
|  template_blade_file  | string |  Blade file that serves as a template  |
|  add_template_blade_file  | string |  Blade file that serves as a template  |
|  group_key_name  | string |  Those with the same specified key value can be grouped together  |

```php
[
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
];
```

#### Required key for GroupLumpFileCreator Pattern

|  name  |  type  |  detail  |
| ---- | ---- | ---- |
|  create_type  | string |  Output pattern  |
|  read_path  | string |  Directory path where yaml files are located  |
|  output_directory_path  | string |  Output destination path  |
|  group_key_name  | string |  Those with the same specified key value can be grouped together  |
|  extension  | string |  Output file extension  |
|  template_blade_file  | string |  Blade file that serves as a template  |
|  is_override  | bool |  Whether it is okay to overwrite the file when outputting the file  |

```php
[
    'create_type'             => 'GroupLumpFileCreator',
    'read_path'               => base_path('definition_document/http/api'),
    'except_file_names'       => ['Base'],
    'output_directory_path'   => app_path('Presentations/Http/Api/Controllers'),
    'group_key_name'          => 'controller_name',
    'extension'               => 'php',
    'template_blade_file'     => 'blueprint::Foundation.Controller.normal',
    'extends_class_name'      => 'BaseController',
];
```

## Related open source tool
[Spreadsheet Converter](https://github.com/stepupdream/spread-sheet-converter)  

## Contributing
Please see [CONTRIBUTING](https://github.com/stepupdream/blueprint/blob/master/.github/CONTRIBUTING.md) for details.
 
## License

The Blueprint is open-sourced software licensed under the [MIT license](https://choosealicense.com/licenses/mit/)
