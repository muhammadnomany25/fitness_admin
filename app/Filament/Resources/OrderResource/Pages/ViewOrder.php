<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public static function getNavigationLabel(): string
    {
        return trans('orders.viewAction');
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
//            Action::make('history log')
//                ->url(fn($record) => Activities::getSubjectUrl($record)),

//            Action::make('technician')
//                ->label(trans('orders.changeOrAssignTechnician'))
//                ->form([
//                    Select::make('technician_id')
//                        ->relationship(name: 'technician', titleAttribute: 'name')
//                        ->searchable()
//                        ->label(trans('orders.technician'))
//                        ->preload()
//                        ->default($this->record->technician_id),
//                ])
//                ->action(function (array $data, Order $record): void {
//                    $this->record->update([
//                        'technician_id' => $data['technician_id'],
//                    ]);
//
//                    Notification::make()
//                        ->title('Success')
//                        ->body('Order Updated Successfully')
//                        ->success()
//                        ->send();
//                    $this->refreshFormData(['technician_id']);
//                })
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        ToggleButtons::make('status')
                            ->label(trans('orders.status_'))
                            ->inline()
                            ->options(OrderStatus::class)
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('client_name')
                            ->required()
                            ->label(trans('orders.client_name'))
                            ->maxLength(255),

                        TextInput::make('client_phone')
                            ->tel()
                            ->string()
                            ->telRegex('/^([4569]\d{7})$/')
                            ->prefix('+965')
                            ->label(trans('orders.client_phone'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('client_address')
                            ->required()
                            ->label(trans('orders.client_address'))
                            ->maxLength(255),

                        Select::make('technician_id')
                            ->relationship(name: 'technician', titleAttribute: 'name')
                            ->searchable()
                            ->label(trans('orders.technician'))
                            ->preload(),

                        Datepicker::make('visit_date')->label('Visit Date')->nullable(),

                        TextInput::make('notes')
                            ->required()
                            ->label(trans('orders.notes_'))
                            ->maxLength(255)
                            ->columnSpan(2),

                    ])
                    ->columnSpan(['lg' => fn(?Order $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label(trans('general.createdAt'))
                            ->content(fn(Order $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label(trans('general.last_modified_at'))
                            ->content(fn(Order $record): ?string => $record->updated_at?->diffForHumans()),

                        Placeholder::make('user_id')
                            ->label(trans('orders.order_creator'))
                            ->content(fn(Order $record): ?string => $record->user?->name),

                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Order $record) => $record === null),
            ])
            ->columns(3);
    }
}
