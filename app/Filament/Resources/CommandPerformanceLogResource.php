<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommandPerformanceLogResource\Pages;
use App\Filament\Resources\CommandPerformanceLogResource\Widgets;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\QueryBuilder\Constraints;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Monitor\CommandPerformanceLog;

class CommandPerformanceLogResource extends Resource
{

    protected static ?string $model = CommandPerformanceLog::class;

    protected static ?string $navigationGroup = 'Logging';

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $recordTitleAttribute = 'command';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Command Logs');
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->translateLabel()
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('command')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        Forms\Components\DatePicker::make('started_at')
                            ->required()
                            ->date()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('query_time')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('query_count')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('runtime')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('memory_usage')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('command')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('query_time')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('query_count')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('memory_usage')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('runtime')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('started_at')->translateLabel()->sortable(),
            ])
            ->filters([
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Constraints\TextConstraint::make('command')->translateLabel(),
                        Constraints\NumberConstraint::make('query_time')->translateLabel(),
                        Constraints\NumberConstraint::make('query_count')->translateLabel(),
                        Constraints\NumberConstraint::make('memory_usage')->translateLabel(),
                        Constraints\NumberConstraint::make('runtime')->translateLabel(),
                        Constraints\DateConstraint::make('started_at')->translateLabel(),
                    ])
                    ->constraintPickerColumns(),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->actions([
                Tables\Actions\ViewAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommandPerformanceLogs::route('/'),
            'view' => Pages\ViewCommandPerformanceLog::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
//                SoftDeletingScope::class,
            ]);
    }
}
