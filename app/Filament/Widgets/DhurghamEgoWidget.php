<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DhurghamEgoWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("This masterpiece?", "Coded by Dhurgham. You’re welcome.")
                ->icon('heroicon-o-bolt')
                ->color('success')
                ->extraAttributes([
                    'class' => 'text-left',
                ]),
            Stat::make("Need to talk?", "Contact me for bugs, features, or praise.")
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'text-left',
                ]),
        ];
    }
}
