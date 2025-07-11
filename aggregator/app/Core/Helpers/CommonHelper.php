<?php

namespace App\Core\Helpers;

class CommonHelper
{
    /**
     * @throws \Throwable
     */
    public static function checkArrayFieldIsPresentAndRemoveDuplicates(array $array, string $arrayFieldKey): array
    {
        return array_map(function ($v) use ($arrayFieldKey) {
            throw_if(!isset($v[$arrayFieldKey]), \App\Core\Exceptions\Exception::class, "$arrayFieldKey field is not set");
            $v[$arrayFieldKey] = array_unique($v[$arrayFieldKey]);
            return $v;
        }, $array);
    }
}
