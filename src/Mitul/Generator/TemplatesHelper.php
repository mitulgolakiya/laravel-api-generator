<?php

namespace Mitul\Generator;

class TemplatesHelper
{
    public function getTemplate($template, $type)
    {
        $path = base_path('resources/api-generator-templates/'.$type.'/'.$template.'.stub');

        if (!file_exists($path)) {
            $path = __DIR__.'/../../../templates/'.$type.'/'.$template.'.stub';
        }

        $fileData = file_get_contents($path);

        return $fileData;
    }
}
