<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs;
use Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog;
use Modules\Filament\Resources\JobPerformanceLogResource\Widgets\StatsOverview;
use Modules\Monitoring\Models\JobPerformanceLog;
use Override;

final class JobPerformanceLogResource extends Resource
{
    protected static ?string $model = JobPerformanceLog::class;

    protected static ?string $navigationGroup = 'Logging';

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    protected static ?string $recordTitleAttribute = 'job';

    protected static ?int $navigationSort = 3;

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Job Logs');
    }

    #[Override]
    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    #[Override]
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->translateLabel()
                    ->columns()
                    ->schema([
                        TextInput::make('job')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        TextInput::make('connection')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        TextInput::make('queue')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        TextInput::make('attempts')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        DatePicker::make('started_at')
                            ->required()
                            ->date()
                            ->translateLabel(),
                        TextInput::make('query_time')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                        TextInput::make('query_count')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                        TextInput::make('runtime')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                        TextInput::make('memory_usage')
                            ->required()
                            ->numeric()
                            ->translateLabel(),
                    ]),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job')->translateLabel()->sortable()->searchable(),
                TextColumn::make('queue')->translateLabel()->sortable()->searchable(),
                TextColumn::make('connection')->translateLabel()->sortable()->searchable(),
                TextColumn::make('attempts')->translateLabel()->sortable(),
                TextColumn::make('query_time')->translateLabel()->sortable(),
                TextColumn::make('query_count')->translateLabel()->sortable(),
                TextColumn::make('memory_usage')->translateLabel()->sortable(),
                TextColumn::make('runtime')->translateLabel()->sortable(),
                TextColumn::make('started_at')->translateLabel()->sortable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('job')->translateLabel(),
                        TextConstraint::make('connection')->translateLabel(),
                        TextConstraint::make('queue')->translateLabel(),
                        NumberConstraint::make('attempts')->translateLabel(),
                        NumberConstraint::make('query_time')->translateLabel(),
                        NumberConstraint::make('query_count')->translateLabel(),
                        NumberConstraint::make('memory_usage')->translateLabel(),
                        NumberConstraint::make('runtime')->translateLabel(),
                        DateConstraint::make('started_at')->translateLabel(),
                    ])
                    ->constraintPickerColumns(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->actions([
                ViewAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([

            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListJobPerformanceLogs::route('/'),
            'view'  => ViewJobPerformanceLog::route('/{record}'),
        ];
    }

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                //                SoftDeletingScope::class,
            ]);
    }
}
