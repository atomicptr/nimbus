<?php

namespace App\Enums;

enum PostPublishingStatus
{
    case draft;
    case timed;
    case published;
}
