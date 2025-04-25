<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobPerformanceLogResource\Pages;
use App\Filament\Resources\JobPerformanceLogResource\Widgets;
use App\Models\Monitor\JobPerformanceLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\QueryBuilder\Constraints;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobPerformanceLogResource extends Resource
{
    protected static ?string $model = JobPerformanceLog::class;

    protected static ?string $navigationGroup = 'Logging';

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    protected static ?string $recordTitleAttribute = 'job';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Job Logs');
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
                        Forms\Components\TextInput::make('job')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('connection')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('queue')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('attempts')
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
                Tables\Columns\TextColumn::make('job')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('queue')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('connection')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('attempts')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('query_time')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('query_count')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('memory_usage')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('runtime')->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('started_at')->translateLabel()->sortable(),
            ])
            ->filters([
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Constraints\TextConstraint::make('job')->translateLabel(),
                        Constraints\TextConstraint::make('connection')->translateLabel(),
                        Constraints\TextConstraint::make('queue')->translateLabel(),
                        Constraints\NumberConstraint::make('attempts')->translateLabel(),
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
            'index' => Pages\ListJobPerformanceLogs::route('/'),
            'view' => Pages\ViewJobPerformanceLog::route('/{record}'),
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
