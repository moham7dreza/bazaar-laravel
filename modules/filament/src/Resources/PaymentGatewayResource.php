<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Modules\Filament\Resources\PaymentGatewayResource\Pages\ListPaymentGateways;
use Modules\Filament\Resources\PaymentGatewayResource\Pages\CreatePaymentGateway;
use Modules\Filament\Resources\PaymentGatewayResource\Pages\EditPaymentGateway;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use App\Enums\PaymentGateways;
use App\Models\PaymentGateway;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class PaymentGatewayResource extends Resource
{
    protected static ?string $model                = PaymentGateway::class;
    protected static string | \UnitEnum | null $navigationGroup      = 'Sale';
    protected static string | \BackedEnum | null $navigationIcon       = 'heroicon-o-shopping-bag';
    protected static ?string $recordTitleAttribute = 'gateway';
    protected static ?int $navigationSort          = 1;

    public static function getNavigationLabel(): string
    {
        return __('Payment Gateways');
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...self::getConfigInputs(),

                Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('gateway')
                    ->formatStateUsing(fn ($state): string => __('payment-gateways.' . $state)),

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
            ->recordActions([
                EditAction::make(),

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
            'index'  => ListPaymentGateways::route('/'),
            'create' => CreatePaymentGateway::route('/create'),
            'edit'   => EditPaymentGateway::route('/{record}/edit'),
        ];
    }

    private static function getConfigInputs(): array
    {
        return [

            Select::make('gateway')
                ->options(PaymentGateways::class)
                ->required()
                ->live(),

            Section::make('gateway config')
                ->schema(
                    fn (Get $get) => $get('gateway') > 0
                    ? PaymentGateways::from($get('gateway'))->configInputs()
                    : []
                ),

        ];
    }
}
