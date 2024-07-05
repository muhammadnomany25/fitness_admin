<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{

    case New = 'new';

    case InProgress = 'inProgress';

    case Completed = 'Completed';

    case Duplicated = 'Duplicated';

    case Reassigned = 'Reassigned';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => trans('status.' . 'new'),
            self::InProgress => trans('status.' .'inProgress'),
            self::Duplicated => trans('status.' .'Duplicated'),
            self::Reassigned => trans('status.' .'Reassigned'),
            self::Completed => trans('status.' .'Completed')
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New, self::Reassigned => 'info',
            self::InProgress => 'warning',
            self::Duplicated => 'danger',
            self::Completed => 'success',
        };
    }

    public function label(): string
    {
        return trans('status.' . $this->value);
    }


    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-sparkles',
            self::Duplicated => 'heroicon-m-arrow-path',
            self::InProgress => 'heroicon-m-truck',
            self::Reassigned => 'heroicon-m-check-badge',
            self::Completed => 'heroicon-m-check-badge'
        };
    }
}
