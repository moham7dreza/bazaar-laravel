<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use App\Enums\PaymentGateways;
use App\Models\PaymentGateway;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class PaymentGatewayResource extends Resource
{
    protected static ?string $model                = PaymentGateway::class;
    protected static ?string $navigationGroup      = 'Sale';
    protected static ?string $navigationIcon       = 'heroicon-o-shopping-bag';
    protected static ?string $recordTitleAttribute = 'gateway';
    protected static ?int $navigationSort          = 1;

    public static function getNavigationLabel(): string
    {
        return __('Payment Gateways');
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
                    ->formatStateUsing(fn ($state): string => __('payment-gateways.' . $state)),

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
            'index'  => PaymentGatewayResource\Pages\ListPaymentGateways::route('/'),
            'create' => PaymentGatewayResource\Pages\CreatePaymentGateway::route('/create'),
            'edit'   => PaymentGatewayResource\Pages\EditPaymentGateway::route('/{record}/edit'),
        ];
    }

    protected static function getConfigInputs(): array
    {
        return [

            Forms\Components\Select::make('gateway')
                ->options(PaymentGateways::class)
                ->required()
                ->live(),

            Forms\Components\Section::make('gateway config')
                ->schema(
                    fn (Get $get) => $get('gateway') > 0
                    ? PaymentGateways::from($get('gateway'))->configInputs()
                    : []
                ),

        ];
    }
}
