<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use App\Enums\PaymentGateways;
use App\Models\PaymentGateway;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Filament\Resources\PaymentGatewayResource\Pages\CreatePaymentGateway;
use Modules\Filament\Resources\PaymentGatewayResource\Pages\EditPaymentGateway;
use Modules\Filament\Resources\PaymentGatewayResource\Pages\ListPaymentGateways;
use Override;

final class PaymentGatewayResource extends Resource
{
    protected static ?string $model                = PaymentGateway::class;
    protected static ?string $navigationGroup      = 'Sale';
    protected static ?string $navigationIcon       = 'heroicon-o-shopping-bag';
    protected static ?string $recordTitleAttribute = 'gateway';
    protected static ?int $navigationSort          = 1;

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Payment Gateways');
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
