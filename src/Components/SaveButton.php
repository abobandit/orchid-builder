<?php

namespace OrchidBuilder\Components;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class SaveButton
{
    public static function create($method = 'createOrUpdateItem'): Rows
    {
        return Layout::rows([
            Button::make(__('Сохранить'))
                ->type(Color::BASIC)
                ->icon('bs.check-circle')
                ->method($method)
        ]);
    }
}
