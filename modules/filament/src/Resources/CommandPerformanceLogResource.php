<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs;
use Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog;
use Modules\Filament\Resources\CommandPerformanceLogResource\Widgets\StatsOverview;
use Modules\Monitoring\Models\CommandPerformanceLog;
use Override;

final class CommandPerformanceLogResource extends Resource
{
    protected static ?string $model = CommandPerformanceLog::class;

    protected static ?string $navigationGroup = 'Logging';

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $recordTitleAttribute = 'command';

    protected static ?int $navigationSort = 2;

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Command Logs');
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
                        TextInput::make('command')
                            ->required()
                            ->string()
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
                TextColumn::make('command')->translateLabel()->sortable()->searchable()
                    ->limit(20)
                    ->tooltip(fn ($record): string => $record->command),
                TextColumn::make('status')->translateLabel()->badge(),
                TextColumn::make('query_time')->translateLabel()->sortable(),
                TextColumn::make('query_count')->translateLabel()->sortable(),
                TextColumn::make('memory_usage')->translateLabel()->sortable(),
                TextColumn::make('runtime')->translateLabel()->sortable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('command')->translateLabel(),
                        NumberConstraint::make('query_time')->translateLabel(),
                        NumberConstraint::make('query_count')->translateLabel(),
                        NumberConstraint::make('memory_usage')->translateLabel(),
                        NumberConstraint::make('runtime')->translateLabel(),
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
            'index' => ListCommandPerformanceLogs::route('/'),
            'view'  => ViewCommandPerformanceLog::route('/{record}'),
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
