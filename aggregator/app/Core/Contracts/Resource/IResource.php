<?php

namespace App\Core\Contracts\Resource;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;

interface IResource extends Arrayable, Responsable, \JsonSerializable
{

}
