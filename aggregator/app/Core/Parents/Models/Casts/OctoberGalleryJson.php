<?php

namespace App\Core\Parents\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Database\Eloquent\Casts\Json;

class OctoberGalleryJson implements Castable
{
    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes {
            public function get($model, $key, $value, $attributes)
            {
                $preparePath = fn($path) => preg_replace("/^\/+/", "", $path);

                $noImageUrl = url("media/common/no-image.png");

                $data = is_string($attributes[$key]) ? Json::decode($attributes[$key]) : $attributes[$key] ?? [];

                if (empty($data)) {
                    $data[] = [
                        'type' => 'image',
                        'image_desktop' => $noImageUrl,
                        'image_mobile' => $noImageUrl,
                        'is_common' => true
                    ];
                    return is_array($data) ? new ArrayObject($data) : null;
                }

                foreach ($data as &$item) {

                    if (!is_array($item)) continue;

                    $item['type'] = $item['type'] ?? 'image';

                    if (
                        $item['type'] == 'image'
                        && isset($item['image_desktop']) && isset($item['image_mobile'])
                        && !preg_match("/https?:/", $item['image_desktop'])
                    ) {
                        $item['image_desktop'] = $item['image_desktop']
                            ? url("media/" . $preparePath($item['image_desktop']))
                            : $noImageUrl;
                        $item['image_mobile'] = $item['image_mobile']
                            ? url("media/" . $preparePath($item['image_mobile']))
                            : ( // use desktop image as mobile image if empty only for room categories:
                                ($model instanceof \App\Modules\DataAggregation\Test)
                                ? $item['image_desktop']
                                : $noImageUrl
                            );
                    }

                    if (
                        $item['type'] == 'video'
                        && isset($item['video_poster']) && isset($item['video'])
                        && !preg_match("/https?:/", $item['video_poster'])
                    ) {
                        $item['video_poster'] = $item['video_poster']
                            ? url("media/" . $preparePath($item['video_poster']))
                            : $noImageUrl;
                        if ($item['video']) {
                            $item['video'] = url("media/" . $preparePath($item['video']));
                        }
                    }

                }

                return is_array($data) ? new ArrayObject($data) : null;
            }

            public function set($model, $key, $value, $attributes)
            {
                return [$key => Json::encode($value)];
            }

            public function serialize($model, string $key, $value, array $attributes)
            {
                return $value->getArrayCopy();
            }
        };
    }
}
