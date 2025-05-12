<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use App\Enums\SMSGateways;
use App\Models\SmsGateway;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class SmsGatewayResource extends Resource
{
    protected static ?string $model                = SmsGateway::class;
    protected static ?string $navigationGroup      = 'Sale';
    protected static ?string $navigationIcon       = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $recordTitleAttribute = 'gateway';
    protected static ?int $navigationSort          = 2;
    public static function getNavigationLabel(): string
    {
        return __('SMS Gateways');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...self::getConfigInputs(),
                Forms\Components\Toggle::make('status')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gateway')
                    ->formatStateUsing(fn ($state): string => __('sms-gateways.' . $state)),

                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index'  => SmsGatewayResource\Pages\ListSmsGateways::route('/'),
            'create' => SmsGatewayResource\Pages\CreateSmsGateway::route('/create'),
            'edit'   => SmsGatewayResource\Pages\EditSmsGateway::route('/{record}/edit'),
        ];
    }

    private static function getConfigInputs(): array
    {
        return [

            Forms\Components\Select::make('gateway')
                ->options(SMSGateways::class)
                ->required()
                ->live(),

            Forms\Components\Section::make('gateway config')
                ->schema(
                    fn (Get $get) => $get('gateway') > 0
                    ? SMSGateways::from($get('gateway'))->configInputs()
                    : []
                ),

        ];
    }

}
