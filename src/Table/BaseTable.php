<?php

namespace Abobandit\OrchidBuilder\Table;


use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

abstract class BaseTable extends Table
{
    protected string $entity;
    protected ?string $request;
    protected string $modalName = 'editModal';
    public function setModalName(string $name): void
    {
        $this->modalName .= $name;
    }

    protected function getAsyncData($data): array
    {
        return ['id' => $data->id, 'entity' => $this->entity];
    }
    protected function addActions($method = 'createOrUpdateItem',$action = null): TD
    {
        return TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn($data) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([
                    ModalToggle::make('Edit')
                        ->icon('bs.pencil')
                        ->modal($this->modalName)
                        ->method($method)
                        ->asyncParameters($this->getAsyncData($data)),
                    !(is_callable($action)) ? Input::make()->type('hidden') : $action($data),
                    Button::make('Delete')
                        ->icon('bs.trash3')
                        ->confirm(__('Запись будет удалена безвозвратно.'))
                        ->method('deleteItem',$this->getAsyncData($data)),
                ]));
    }
}
