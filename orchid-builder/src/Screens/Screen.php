<?php


namespace OrchidBuilder\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Screen as BaseScreen;
use Orchid\Support\Facades\Toast;

abstract class Screen extends BaseScreen
{

    public function asyncQuery(Request $request): array
    {
        $item = $this->getEntityByID($request);
        return [
            'item' => $item,
        ];
    }
    public function deleteItem(Request $request): void
    {
        $this->getEntityByID($request)->delete();

        Toast::info('Запись удалена.');
    }

    protected function getEntityByID(Request $request)
    {
        $entity = $request->query('entity');
        $id = $request->input('id');
        return $entity::findOrFail($id);
    }

    /**
     * Create or update a record.
     *
     * @param Request $request
     */
    final public function createOrUpdateItem(Request $request,$key = 'item'): void
    {
        $rules = $this->getRules($request);
        $data = $request->validate(...$rules)[$key];
        $entity = $request->input('entity');
        $entity::updateOrCreate(['id' => $data['id'] ?? null], $data);

        $toastInfo = (is_null($data['id'])) ? 'Данные загружены' : 'Данные обновлены';

        Toast::info($toastInfo);
    }
    abstract protected function insertModals() : array;
}
