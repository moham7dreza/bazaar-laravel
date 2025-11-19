<?php

declare(strict_types=1);

namespace Modules\Filament\Resources;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Modules\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\Filament\Resources\UserResource\Pages\EditUser;
use Modules\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\Filament\Resources\UserResource\Widgets\StatsOverview;
use Override;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;
use Rmsramos\Activitylog\RelationManagers\ActivitylogRelationManager;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 0;

//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Users');
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
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->required(fn (string $context): bool => 'create' === $context)
                            ->maxLength(255),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrated(fn ($state): bool => filled($state))
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
                                Toggle::make('is_active')
                                    ->required()
                                    ->translateLabel(),
                            ]),
                    ]),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->translateLabel()->sortable()->searchable(),
                TextColumn::make('email')->translateLabel()->sortable()->searchable(),
                TextColumn::make('mobile')->translateLabel()->searchable(),
                TextColumn::make('is_active')->translateLabel()->sortable()->badge(),
                TextColumn::make('suspended_at')->jalaliDate()->translateLabel(),
                TextColumn::make('suspended_until')->jalaliDate()->translateLabel(),
                TextColumn::make('city.name')->translateLabel(),
                TextColumn::make('mobile_verified_at')->jalaliDate()->translateLabel(),
                TextColumn::make('email_verified_at')->jalaliDate()->translateLabel(),
            ])
            ->filters([
                DateRangeFilter::make('suspended_at'),
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
            ->actions([
                Impersonate::make(),
                EditAction::make(),
                ActivityLogTimelineTableAction::make('Activities')->limit(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                ExportBulkAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            ActivitylogRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => EditUser::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'mobile'];
    }
}
