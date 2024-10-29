<?php

namespace App\Services;

class TinypngAPIService
{
    public function optimizeImage($image): string
    {
        \Tinify\setKey(config('app.tinypng_api_key'));
        $source = \Tinify\fromFile($image);
        $resized = $source->resize(array(
            "method" => "cover",
            "width" => 70,
            "height" => 70
        ));
        $filePath = 'optimizedPhoto_' . time() . '.jpg';
        $resized->toFile($filePath);

        return $filePath;
    }
}
