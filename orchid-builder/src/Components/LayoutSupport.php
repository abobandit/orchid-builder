<?php

namespace OrchidBuilder\Components;

use Orchid\Screen\Fields\Input;

class LayoutSupport
{

    public static function hiddenInputs($entity, $request,$key = 'item'): array
    {
        return [
            Input::make($key.'.id')
                ->type('hidden'),
            Input::make('entity')
                ->value($entity)
                ->type('hidden'),
            Input::make('rules')
                ->value($request)
                ->type('hidden')
        ];
    }
}
