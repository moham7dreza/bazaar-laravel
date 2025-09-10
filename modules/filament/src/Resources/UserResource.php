<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Enums\FiltersLayout;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Filament\Actions\EditAction;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Modules\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder\Constraints;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Modules\Filament\Resources\UserResource\Widgets\StatsOverview;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;
use Rmsramos\Activitylog\RelationManagers\ActivitylogRelationManager;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static string | \UnitEnum | null $navigationGroup = 'User';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 0;

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->translateLabel()
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->translateLabel(),
                        TextInput::make('mobile')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => 'create' === $context)
                            ->maxLength(255),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => 'create' === $context)
                            ->same('password')
                            ->label('Confirm Password'),
                        Select::make('city_id')
                            ->translateLabel()
                            ->searchable()
                            ->preload()
                            ->relationship('city', 'name'),
                        Section::make('Access')
                            ->translateLabel()
                            ->columns()
                            ->schema([
                                Select::make('roles')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->preload()
                                    ->searchable()
                                    ->translateLabel()
                                    ->relationship('roles', 'name'),
                            ]),
                        Section::make('Suspension')
                            ->translateLabel()
                            ->columns()
                            ->schema([
                                DateTimePicker::make('suspended_at')
                                    ->jalali()
                                    ->nullable()
                                    ->translateLabel(),
                                DateTimePicker::make('suspended_until')
                                    ->jalali()
                                    ->nullable()
                                    ->translateLabel(),
                            ]),
                        Section::make('Toggles')
                            ->translateLabel()
                            ->columns()
                            ->schema([
                                Toggle::make('user_type')
                                    ->required()
                                    ->translateLabel(),
                                Toggle::make('is_active')
                                    ->required()
                                    ->translateLabel(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->translateLabel()->sortable()->searchable(),
                TextColumn::make('email')->translateLabel()->sortable()->searchable(),
                TextColumn::make('mobile')->translateLabel()->searchable(),
                TextColumn::make('user_type')->translateLabel()->sortable()->badge(),
                TextColumn::make('is_active')->translateLabel()->sortable()->badge(),
                TextColumn::make('suspended_at')->jalaliDate()->translateLabel(),
                TextColumn::make('suspended_until')->jalaliDate()->translateLabel(),
                TextColumn::make('city.name')->translateLabel(),
                TextColumn::make('mobile_verified_at')->jalaliDate()->translateLabel(),
                TextColumn::make('email_verified_at')->jalaliDate()->translateLabel(),
            ])
            ->filters([
                DateRangeFilter::make('suspended_at'),
                SelectFilter::make('user_type')
                    ->translateLabel()
                    ->options([
                        '0' => 'User',
                        '1' => 'Admin',
                    ])
                    ->multiple()
                    ->searchable(),
                Filter::make('mobile_verified_at')
                    ->label('not verified mobile')
                    ->translateLabel()
                    ->query(fn (Builder $query): Builder => $query->whereNull('mobile_verified_at')),
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('name')->translateLabel(),
                        TextConstraint::make('email')->translateLabel(),
                        TextConstraint::make('mobile')->translateLabel(),
                        TextConstraint::make('mobile_verified_at')->translateLabel(),
                        TextConstraint::make('email_verified_at')->translateLabel(),
                        TextConstraint::make('suspended_at')->translateLabel(),
                        TextConstraint::make('suspended_until')->translateLabel(),
                    ])
                    ->constraintPickerColumns(),
            ], layout: FiltersLayout::Dropdown)
            ->deferFilters()
            ->recordActions([
                Impersonate::make(),
                EditAction::make(),
                ActivityLogTimelineTableAction::make('Activities')->limit(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                ExportBulkAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ActivitylogRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'mobile'];
    }
}
