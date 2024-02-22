<?php

namespace App\Enums;

enum PostStatus: int
{
    case PUBLISHED = 3;
    case AWAITING_APPROVAL = 1;
    case DRAFT = 2;
    case QUEUED = 5;
    case ARCHIVED = 4;

    public static function getValues()
    {
        return array_map(
            fn(PostStatus $status) => $status->value,
            self::cases()
        );
    }
    public static function getName($statusValue)
    {
        return collect(self::cases())->where('value', $statusValue)
            ->first()->name;
    }

    public static function getIcon($statusValue)
    {
        $iconClass = "ti ";
        switch ((int) $statusValue) {
            case self::AWAITING_APPROVAL->value:
                $iconClass .= 'ti-hourglass-low';
                break;
            case self::DRAFT->value:
                $iconClass .= 'ti-pen';
                break;
            case self::PUBLISHED->value:
                $iconClass .= 'ti-circle-check';
                break;
            case self::ARCHIVED->value:
                $iconClass .= 'ti-archive';
                break;
            case self::QUEUED->value:
                $iconClass .= 'ti-clock ';
                break;
            default:
                $iconClass = '';

        }
        return $iconClass;
    }
}
