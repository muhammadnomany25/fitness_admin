<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn (User $record) => $record->email != 'admin@akc.com'),
            Actions\Action::make('changePassword')
                ->label(trans('users.changePassword'))
                ->form([
                    TextInput::make('new_password')
                        ->label(trans('users.new_password'))
                        ->password()
                        ->required()
                        ->revealable(),
                    TextInput::make('new_password_confirmation')
                        ->password()
                        ->label(trans('users.new_password_confirmation'))
                        ->required()
                        ->same('new_password')
                        ->revealable()
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'password' => Hash::make($data['new_password']),
                    ]);
                    Notification::make()
                        ->title('Success')
                        ->body('Password Updated Successfully')
                        ->success()
                        ->send();
                })
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('users.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(trans('users.email'))
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->visible(fn (User $record) => $record->email != 'super@akc.com'),

//                Forms\Components\CheckboxList::make('roles')
//                    ->label(trans('users.roles'))
//                    ->relationship('roles', 'name')
//                    ->visible(fn (User $record) => $record->email != 'admin@akc.com')
            ]);
    }
}
