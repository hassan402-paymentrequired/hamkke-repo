<?php

namespace App\Enums;

enum PostStatus: int
{
    case AWAITING_APPROVAL = 1;
    case DRAFT = 2;
    case PUBLISHED = 3;
    case ARCHIVED = 4;
    case QUEUED = 5;

    public static function getValues()
    {
        return array_map(
            fn(PostStatus $status) => $status->value,
            self::cases()
        );
    }
}
