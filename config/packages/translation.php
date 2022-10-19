<?php

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    $framework
        ->defaultLocale('%env(DEFAULT_LOCALE)%')
        ->translator()
        ->defaultPath('%kernel.project_dir%/translations');
};
