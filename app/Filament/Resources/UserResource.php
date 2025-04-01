<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\QueryBuilder\Constraints;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;
use Rmsramos\Activitylog\RelationManagers\ActivitylogRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->translateLabel()
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->translateLabel(),
                        Forms\Components\TextInput::make('mobile')
                            ->required()
                            ->string()
                            ->translateLabel(),
                        Forms\Components\Select::make('city_id')
                            ->translateLabel()
                            ->searchable()
                            ->preload()
                            ->relationship('city', 'name'),
                        Forms\Components\Toggle::make('user_type')
                            ->required()
                            ->translateLabel(),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->translateLabel(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('mobile')->translateLabel()->searchable(),
                Tables\Columns\TextColumn::make('user_type')->translateLabel()->sortable()->badge(),
                Tables\Columns\TextColumn::make('is_active')->translateLabel()->sortable()->badge(),
                Tables\Columns\TextColumn::make('city.name')->translateLabel(),
                Tables\Columns\TextColumn::make('mobile_verified_at')->translateLabel(),
                Tables\Columns\TextColumn::make('email_verified_at')->translateLabel(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_type')
                    ->translateLabel()
                    ->options([
                        '0' => 'User',
                        '1' => 'Admin',
                    ])
                    ->multiple()
                    ->searchable(),
                Tables\Filters\Filter::make('mobile_verified_at')
                    ->label('not verified mobile')
                    ->translateLabel()
                    ->query(fn(Builder $query): Builder => $query->whereNull('mobile_verified_at')),
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Constraints\TextConstraint::make('name')->translateLabel(),
                        Constraints\TextConstraint::make('email')->translateLabel(),
                        Constraints\TextConstraint::make('mobile')->translateLabel(),
                        Constraints\TextConstraint::make('mobile_verified_at')->translateLabel(),
                        Constraints\TextConstraint::make('email_verified_at')->translateLabel(),
                    ])
                    ->constraintPickerColumns(),
            ])
            ->deferFilters()
            ->actions([
                Tables\Actions\EditAction::make(),
                ActivityLogTimelineTableAction::make('Activities')->limit(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
