<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Modules\Filament\Resources\SmsLogResource\Widgets\StatsOverview;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs;
use Modules\Filament\Resources\SmsLogResource\Pages\ViewSmsLog;
use App\Models\SmsLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class SmsLogResource extends Resource
{
    protected static ?string $model = SmsLog::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Logging';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $recordTitleAttribute = 'message';

    protected static ?int $navigationSort = 4;

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }

    public static function getNavigationLabel(): string
    {
        return __('Sms Logs');
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message_id')->translateLabel()->sortable()->searchable(),
                TextColumn::make('connector')->translateLabel()->badge(),
                TextColumn::make('type')->translateLabel(),
                TextColumn::make('status')->translateLabel()->badge(),
                TextColumn::make('message_type')->translateLabel(),
                TextColumn::make('sender_number')->translateLabel(),
                TextColumn::make('to')->translateLabel(),
                TextColumn::make('sent_at')->translateLabel(),
                TextColumn::make('delivered_at')->translateLabel(),
                TextColumn::make('user.name')->translateLabel(),
            ])
            ->filters([

            ])
            ->recordActions([

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSmsLogs::route('/'),
            'view'  => ViewSmsLog::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('sent_at')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
