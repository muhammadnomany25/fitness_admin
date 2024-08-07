<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryDietResource\Pages;
use App\Models\CategoryDiet;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class CategoryDietResource extends Resource
{
    protected static ?string $model = CategoryDiet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Diet';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make("status")
                    ->label("Active")
                    ->onColor('success')
                    ->offColor('danger')
                    ->default('1')
                    ->columnSpan(2),
                FileUpload::make('image')
                    ->image()
                    ->openable()
                    ->required()
                    ->columnSpan(2),
                Forms\Components\TextInput::make('titleAr')
                    ->maxLength(255)
                    ->default(null)
                    ->required(),
                Forms\Components\TextInput::make('titleEn')
                    ->maxLength(255)
                    ->default(null)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('titleAr')
                    ->searchable(),
                Tables\Columns\TextColumn::make('titleEn')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label("Active")
                    ->onColor('success')
                    ->offColor('danger')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListCategoryDiets::route('/'),
            'create' => Pages\CreateCategoryDiet::route('/create'),
            'edit' => Pages\EditCategoryDiet::route('/{record}/edit'),
        ];
    }
}
