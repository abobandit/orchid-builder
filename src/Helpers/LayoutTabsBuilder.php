<?php


namespace Abobandit\OrchidBuilder\Helpers;

use Abobandit\OrchidBuilder\Components\ProcessModals;
use Orchid\Screen\Layout as LayoutScreen;
use Orchid\Screen\Layouts\Modal;
use Orchid\Support\Facades\Layout;

class LayoutTabsBuilder
{
    /**
     * Построение вкладок для Orchid Screen с модалками создания/редактирования.
     *
     * @param string $entityKey Ключ для toggle (например: 'page', 'section', 'group')
     * @param string $entityTitle Отображаемое название сущности в интерфейсе (например: 'страницу', 'секцию', 'группу')
     * @param iterable $items Коллекция моделей (CPage[], CSection[], COptionGroup[] и т. п.)
     * @param callable $formFactory Фабрика формы редактирования: fn(object $item): object
     * @param callable $tableFactory Фабрика таблицы: fn(object $item, string $slug): object
     * @param callable|null $createFormFactory Фабрика формы создания сущности: fn(): object|null
     * @param string|null $childrenEntityTitle если название createOrUpdateItem не подходит и нужно заменить Item
     * @return array<LayoutScreen> Массив вкладок для Layout::tabs()
     */
    public static function build(
        string    $entityKey,
        string    $entityTitle,
        iterable  $items,
        callable  $formFactory,
        callable  $tableFactory,
        ?callable $createFormFactory = null,
        ?string   $childrenEntityTitle = null,
        ?string   $size = Modal::SIZE_LG
    ): array
    {
        $tabs = [];
        $createTabs = [];

        // Вкладка создания
        if ($createFormFactory) {
            $createForm = $createFormFactory();
            $createTabs["Создать $entityTitle"] = [
                Layout::rows([
                    ProcessModals::addToggle($entityKey, "createOrUpdate" . ucfirst($entityKey)),
                ]),
                ProcessModals::addModal($createForm, $entityKey, "Создать $entityTitle")->size(Modal::SIZE_LG),
            ];
        }
        $methodName = $childrenEntityTitle ? 'createOrUpdate' . ucfirst($childrenEntityTitle) : 'createOrUpdateItem';
        foreach ($items as $item) {
            $slug = $item->slug;
            $form = $formFactory($item);
            $tabs[$item->title ?? $item->name] = [
                Layout::rows([
                    ProcessModals::addToggle($slug, $methodName),
                ]),
                $tableFactory($item, $slug),
                ProcessModals::addModal($form, $slug)->size($size),
                ProcessModals::editModal($form, $slug)->size($size),
            ];
        }
        return array_merge($tabs, $createTabs);
    }
}
