<?php

namespace App\Core\Data\Dto;

use App\Core\Parents\Dto\Item as Dto;

class MediaDto extends Dto
{
    public ?string $type = null;
    public ?string $image_desktop = null;
    public ?string $image_mobile = null;
    public ?string $image_alt = null;
    public ?string $image_title = null;
    public ?string $video = null;
    public ?string $video_poster = null;
    public ?string $video_title = null;


    public function toArray()
    {
        return [
            'type' => $this->type,
            'image_desktop' => $this->image_desktop,
            'image_mobile' => $this->image_mobile,
            'image_alt' => $this->image_alt,
            'image_title' => $this->image_title,
            'video' => $this->video,
            'video_poster' => $this->video_poster,
            'video_title' => $this->video_title
        ];
    }

    protected function bind(array $payload): void
    {
        $this->type = $payload['type'] ?? null;
        $this->image_desktop = $payload['image_desktop'] ?? null;
        $this->image_mobile = $payload['image_mobile'] ?? null;
        $this->image_alt = $payload['image_alt'] ?? null;
        $this->image_title = $payload['image_title'] ?? null;
        $this->video = $payload['video'] ?? null;
        $this->video_poster = $payload['video_poster'] ?? null;
        $this->video_title = $payload['video_title'] ?? null;
    }
}
