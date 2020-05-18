(2020-04-04) Issue:
2020-04-04
```bash
Generating optimized autoload files
Deprecation Notice: Class App\Http\Controllers\Auth\LoginController located in ./app/Core/Http/Controllers/Auth/LoginController.php does not comply with psr-4 autoloading standard. It will not autoload anymore in Composer v2.0. in phar:///usr/bin/composer/src/Composer/Autoload/ClassMapGenerator.php:201
Deprecation Notice: Class App\Http\Controllers\Auth\VerificationController located in ./app/Core/Http/Controllers/Auth/VerificationController.php does not comply with psr-4 autoloading standard. It will not autoload anymore in Composer v2.0. in phar:///usr/bin/composer/src/Composer/Autoload/ClassMapGenerator.php:201
Deprecation Notice: Class App\Http\Controllers\Auth\ConfirmPasswordController located in ./app/Core/Http/Controllers/Auth/ConfirmPasswordController.php does not comply with psr-4 autoloading standard. It will not autoload anymore in Composer v2.0. in phar:///usr/bin/composer/src/Composer/Autoload/ClassMapGenerator.php:201
Deprecation Notice: Class App\Http\Controllers\Auth\ForgotPasswordController located in ./app/Core/Http/Controllers/Auth/ForgotPasswordController.php does not comply with psr-4 autoloading standard. It will not autoload anymore in Composer v2.0. in phar:///usr/bin/composer/src/Composer/Autoload/ClassMapGenerator.php:201
Deprecation Notice: Class App\Http\Controllers\Auth\ResetPasswordController located in ./app/Core/Http/Controllers/Auth/ResetPasswordController.php does not comply with psr-4 autoloading standard. It will not autoload anymore in Composer v2.0. in phar:///usr/bin/composer/src/Composer/Autoload/ClassMapGenerator.php:201
Deprecation Notice: Class App\Http\Controllers\Auth\RegisterController located in ./app/Core/Http/Controllers/Auth/RegisterController.php does not comply with psr-4 autoloading standard. It will not autoload anymore in Composer v2.0. in phar:///usr/bin/composer/src/Composer/Autoload/ClassMapGenerator.php:201
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
```
Saída do Composer , após executar o comando:
$ sudo docker run --rm -v $(pwd):/app composer install

O comando acima vem de < https://www.howtoforge.com/dockerizing-laravel-with-nginx-mysql-and-docker-compose/ >

(2020-05-18) Fixed: 
apenas corrigi o namespace das classes acima.
Antes eram "App\Http\Controllers\Auth" agora são "App\Core\Http\Controllers\Auth".

END_ISSUE

(2020-04-04) Issue:
Atualmente, a arquitetura está descrita em README.md, como segue:
```txt
App\Applications/

- Api
    - Http
        - Controllers
    - Providers
        - ApiServiceProvider.php
    routes.php

- front
    - Http
        - Controllers
    - Providers
        - FrontServiceProvider.php
    - Resources
        - views
            - _templates/default.blade.php
            - notes/index.blade.php
            ...
        ...
    routes.php
```
Os arquivos de rotas (routes.php) estão fora do diretório Http, porém por uma questão de semantica eles deveriam estar dentro do diretório Http.
A nomenclatura dos diretórios 'Resources' e 'views' também precisa ser definida.

(2020-05-18) Solved:
Movi os arquivos de rotas (routes.php) para dentro dos diretórios Http das respectivas aplicações, semanticamente é o ideal.
Quanto aos nomes "Resources" e "views", podem ficar como estão, já que "views" é um subdiretório de "Resources"
