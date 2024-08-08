<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages;
use App\Filament\Resources\ExerciseResource\RelationManagers;
use App\Models\Exercise;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Workouts';
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
                Select::make('body_part_id')
                    ->relationship(name: 'body_part', titleAttribute: 'titleEn')
                    ->searchable()
                    ->label('Targeted Muscle')
                    ->preload()
                    ->required(),
                Select::make('equipment_id')
                    ->relationship(name: 'equipment', titleAttribute: 'titleEn')
                    ->searchable()
                    ->label('Required Equipment')
                    ->preload(),
                Forms\Components\MarkdownEditor::make('descriptionAr')
                    ->default(null)
                    ->required(),
                Forms\Components\MarkdownEditor::make('descriptionEn')
                    ->default(null)
                    ->required(),
                Forms\Components\TextInput::make('videoUrl')
                    ->default(null)
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->default(null)
                    ->numeric()
                    ->suffix('minutes')
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'gym' => 'Gym Exercise',
                        'home' => 'Home Exercise',
                    ])
                    ->required(),

                Select::make('level')
                    ->label('Difficulty')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ])
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
                Tables\Columns\TextColumn::make('body_part.titleEn')
                    ->label('Targeted Muscle'),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExercises::route('/'),
            'create' => Pages\CreateExercise::route('/create'),
            'edit' => Pages\EditExercise::route('/{record}/edit'),
        ];
    }
}
