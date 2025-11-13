<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Modules\Filament\Resources\SmsLogResource\Widgets\StatsOverview;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs;
use Modules\Filament\Resources\SmsLogResource\Pages\ViewSmsLog;
use App\Models\SmsLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;

final class SmsLogResource extends Resource
{
    protected static ?string $model = SmsLog::class;

    protected static ?string $navigationGroup = 'Logging';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $recordTitleAttribute = 'message';

    protected static ?int $navigationSort = 4;

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Sms Logs');
    }

    #[Override]
    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    #[Override]
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
            ->actions([

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSmsLogs::route('/'),
            'view'  => ViewSmsLog::route('/{record}'),
        ];
    }

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('sent_at')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
