<?php

namespace Abobandit\OrchidBuilder\Screens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

abstract class DynamicTabsScreen extends Screen
{
    public ?Model $editingItem = null;
    abstract protected function initAutoValue(): void;

    public function __get($name)
    {
        $this->initAutoValue();
        return $this->$name ?? null;
    }

    public function __set($name, $value)
    {
        $this->initAutoValue();
        $this->$name = $value;
    }

    public function __call($method, $parameters)
    {
        $this->initAutoValue();

        if (method_exists($this, $method)) {
            return  $this->$method(...$parameters);
        }

        throw new \BadMethodCallException("Метод {$method} не найден");
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [];
    }



    protected function insertModals(): array
    {
        return [];
    }
}
