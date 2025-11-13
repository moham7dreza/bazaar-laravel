<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways;
use Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway;
use Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use App\Enums\SMSGateways;
use App\Models\SmsGateway;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Override;

final class SmsGatewayResource extends Resource
{
    protected static ?string $model                = SmsGateway::class;
    protected static ?string $navigationGroup      = 'Sale';
    protected static ?string $navigationIcon       = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $recordTitleAttribute = 'gateway';
    protected static ?int $navigationSort          = 2;
    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('SMS Gateways');
    }
    #[Override]
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...self::getConfigInputs(),
                Toggle::make('status')
                    ->required(),

            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('gateway')
                    ->formatStateUsing(fn ($state): string => __('sms-gateways.' . $state)),

                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                EditAction::make(),
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
            'index'  => ListSmsGateways::route('/'),
            'create' => CreateSmsGateway::route('/create'),
            'edit'   => EditSmsGateway::route('/{record}/edit'),
        ];
    }

    private static function getConfigInputs(): array
    {
        return [

            Select::make('gateway')
                ->options(SMSGateways::class)
                ->required()
                ->live(),

            Section::make('gateway config')
                ->schema(
                    fn (Get $get) => $get('gateway') > 0
                    ? SMSGateways::from($get('gateway'))->configInputs()
                    : []
                ),

        ];
    }

}
