<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    public static function getNavigationLabel(): string
    {
        return trans('orders.editAction');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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

                        Datepicker::make('visit_date')
                            ->label('Visit Date')
                            ->nullable()
                            ->native(false),

                        MarkdownEditor::make('notes')
                            ->label(trans('orders.notes_'))
                            ->columnSpan('full'),

                    ])
                    ->columnSpan(['lg' => fn(?Order $record) => $record === null ? 3 : 2]),
            ])
            ->columns(3);
    }

    static function getOrderStatusOptions(): array
    {
        $options = [];
        foreach (OrderStatus::cases() as $status) {
            $options[$status->value] = $status->label();
        }
        return $options;
    }

//    protected function getRedirectUrl(): string {
//        return $this->getResource()::getUrl('index');
//    }
}
