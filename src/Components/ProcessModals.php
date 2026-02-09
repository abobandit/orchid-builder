<?php

namespace Abobandit\OrchidBuilder\Components;

use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;

class ProcessModals
{
    public static function addToggle(string $additionalKey = '',string $method = 'createOrUpdateItem',string $title = '')
    {
        return ModalToggle::make(empty($title) ? 'Добавить' : $title)
            ->modal('addModal' . $additionalKey)
            ->method($method)
            ->icon('bs.plus-circle');
    }

    public static function addModal($layouts, string $additionalKey = '',$title = 'Добавить')
    {
        return Layout::modal('addModal' . $additionalKey, $layouts)
            ->title($title);
    }

    public static function editModal($layouts, string $additionalKey = '')
    {

        return Layout::modal('editModal' . $additionalKey, $layouts)
            ->title('Изменить')
            ->async('asyncQuery');
    }
}
