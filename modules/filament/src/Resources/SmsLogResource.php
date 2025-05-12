<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use App\Models\SmsLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class SmsLogResource extends Resource
{
    protected static ?string $model = SmsLog::class;

    protected static ?string $navigationGroup = 'Logging';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $recordTitleAttribute = 'message';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Sms Logs');
    }

    public static function getWidgets(): array
    {
        return [
            SmsLogResource\Widgets\StatsOverview::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('message_id')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('connector')->translateLabel()->badge(),
                Tables\Columns\TextColumn::make('type')->translateLabel(),
                Tables\Columns\TextColumn::make('status')->translateLabel()->badge(),
                Tables\Columns\TextColumn::make('message_type')->translateLabel(),
                Tables\Columns\TextColumn::make('sender_number')->translateLabel(),
                Tables\Columns\TextColumn::make('to')->translateLabel(),
                Tables\Columns\TextColumn::make('sent_at')->translateLabel(),
                Tables\Columns\TextColumn::make('delivered_at')->translateLabel(),
                Tables\Columns\TextColumn::make('user.name')->translateLabel(),
            ])
            ->filters([

            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => SmsLogResource\Pages\ListSmsLogs::route('/'),
            'view'  => SmsLogResource\Pages\ViewSmsLog::route('/{record}'),
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
