<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietResource\Pages;
use App\Filament\Resources\DietResource\RelationManagers;
use App\Models\Diet;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use GalleryJsonMedia\Form\JsonMediaGallery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DietResource extends Resource
{
    protected static ?string $model = Diet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Section::make('Media')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->openable()
                            ->required(),
                    ])->columnSpan(2),
                Forms\Components\TextInput::make('titleAr')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('titleEn')
                    ->maxLength(255)
                    ->default(null),
                Select::make('category_diet_id')
                    ->relationship(name: 'category_diet', titleAttribute: 'titleEn')
                    ->searchable()
                    ->label('Diet Category')
                    ->preload(),
                Forms\Components\TextInput::make('calories')
                    ->maxLength(255)
                    ->numeric()
                    ->suffix('Kcal')
                    ->default(null),
                Forms\Components\TextInput::make('carbs')
                    ->maxLength(255)
                    ->numeric()
                    ->suffix('g')
                    ->default(null),
                Forms\Components\TextInput::make('protein')
                    ->maxLength(255)
                    ->numeric()
                    ->suffix('g')
                    ->default(null),
                Forms\Components\TextInput::make('fat')
                    ->maxLength(255)
                    ->numeric()
                    ->suffix('g')
                    ->default(null),
                Forms\Components\TextInput::make('total_time')
                    ->maxLength(255)
                    ->numeric()
                    ->suffix('minutes')
                    ->default(null),
                Select::make('suitable_for')
                    ->multiple()
                    ->options([
                        'snacks' => 'Snacks',
                        'breakfast' => 'Breakfast',
                        'launch' => 'Launch',
                        'dinner' => 'Dinner',
                    ])
                ->required(),
                MarkdownEditor::make('ingredientsAr')
                    ->columnSpanFull(),
                MarkdownEditor::make('ingredientsEn')
                    ->columnSpanFull(),
                MarkdownEditor::make('descriptionAr')
                    ->columnSpanFull(),
                MarkdownEditor::make('descriptionEn')
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('category_diet_id')
                    ->label('Diet Category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calories')
                    ->searchable(),
                Tables\Columns\TextColumn::make('carbs')
                    ->searchable(),
                Tables\Columns\TextColumn::make('protein')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_time')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label("Active")
                    ->onColor('success')
                    ->offColor('danger'),
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
            'index' => Pages\ListDiets::route('/'),
            'create' => Pages\CreateDiet::route('/create'),
            'edit' => Pages\EditDiet::route('/{record}/edit'),
        ];
    }
}
