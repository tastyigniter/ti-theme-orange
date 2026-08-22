<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Cart\CartItemOptionValue;
use Igniter\Cart\CartItemOptionValues;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Helpers\MainHelper;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Throwable;

final class OrderPreview extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    /** The parameter name used for the order hash code */
    public string $hashParamName = 'hash';

    public ?string $hash = null;

    public string $loginPage = 'account.login';

    /** Account Orders Page */
    public string $ordersPage = 'account.orders';

    public string $checkoutPage = 'checkout.checkout';

    /** Menus Page, page to redirect to when a user clicks the re-order button */
    public string $menusPage = 'local.menus';

    public string $loginUrl = '';

    /** Whether to hide the reorder button, should be hidden on the checkout success page */
    public bool $hideReorderBtn = true;

    public bool $showCancelButton = false;

    protected OrderManager $orderManager;

    protected ?Model $order = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::order-preview',
            'name' => 'igniter.orange::default.component_order_preview_title',
            'description' => 'igniter.orange::default.component_order_preview_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'hashParamName' => [
                'label' => 'URL routing parameter that holds the code used for displaying the order confirmation page.',
                'type' => 'text',
                'validationRule' => 'required|alpha',
            ],
            'loginPage' => [
                'label' => 'Page to redirect to when the user clicks the login button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'ordersPage' => [
                'label' => 'Page to redirect to when viewing as logged in customer and an order is incomplete or not found.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'checkoutPage' => [
                'label' => 'Page to redirect to when viewing as guest and an order is incomplete or not found.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'menusPage' => [
                'label' => 'Page to redirect to when the user clicks the re-order button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'hideReorderBtn' => [
                'label' => 'When rendering the component on the checkout confirmation page, hide the re-order button',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.order-preview', [
            'customer' => Auth::customer(),
            'order' => $this->getProcessedOrder(),
        ]);
    }

    public function boot(): void
    {
        $this->orderManager = resolve(OrderManager::class);
    }

    public function mount(?string $hash = null)
    {
        $this->loginUrl = $this->getLoginPageUrl();
        $this->hash = $hash ?? request()->route()->parameter($this->hashParamName);
        $this->showCancelButton = $this->showCancelButton();

        if (!$processedOrder = $this->getProcessedOrder()) {
            return $this->redirect(MainHelper::pageUrl($this->checkoutPage));
        }

        if ($this->orderManager->isCurrentOrderId($processedOrder->order_id)) {
            $this->orderManager->clearOrder();
        }

        return null;
    }

    public function getStatusWidthForProgressBars(): array
    {
        $result = [];

        $order = $this->getProcessedOrder();

        $result['default'] = 0;
        $result['processing'] = 0;
        $result['completed'] = 0;

        if ($order->status_id == setting('default_order_status')) {
            $result['default'] = 50;
        }

        if (in_array($order->status_id, setting('processing_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 50;
        }

        if (in_array($order->status_id, setting('completed_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 100;
            $result['completed'] = 100;
        }

        return $result;
    }

    public function showCancelButton(): bool
    {
        return $this->getProcessedOrder() && !$this->getProcessedOrder()->isCanceled() && $this->getProcessedOrder()->isCancelable();
    }

    public function onReOrder(): void
    {
        $order = $this->getProcessedOrder();

        rescue(function() use ($order): void {
            $location = resolve('location');
            $currentLocation = $location->current();
            $cartManager = resolve(CartManager::class);
            $currentInstance = $cartManager->getCart()->currentInstance();

            try {
                // Reorder must be validated against the location that owns the historical order,
                // not whichever location happens to be active on the account page.
                $location->clearInternalCache();
                $location->setModel($order->location);
                $cartManager->cartInstance($order->location_id);

                $unavailableItems = $this->getUnavailableReorderItems($order, $cartManager);
                if ($unavailableItems !== []) {
                    throw new ApplicationException($this->formatUnavailableReorderMessage($unavailableItems));
                }

                // Rebuild the legacy payload with current IDs after semantic matching. This lets old
                // orders survive menu rebuilds where the option/value names stayed the same.
                $this->normalizeHistoricalOrderOptions($order);

                $notes = $cartManager->restoreWithOrderMenus($order->getOrderMenus());
                if ($notes) {
                    throw new ApplicationException($this->formatUnavailableReorderMessage($notes));
                }
            } finally {
                $cartManager->getCart()->instance($currentInstance);
                $location->clearInternalCache();
                if ($currentLocation) {
                    $location->setModel($currentLocation);
                }
            }

            flash()->success(sprintf(
                lang('igniter.cart::default.orders.alert_reorder_success'), $order->order_id,
            ));

            $this->redirect(page_url($this->menusPage, [
                'orderId' => $order->order_id,
                'location' => $order->location->permalink_slug,
            ]));
        }, function(Throwable $ex): never {
            throw ValidationException::withMessages(['onReOrder' => $ex->getMessage()]);
        });
    }

    public function onCancel(): void
    {
        $order = $this->getProcessedOrder();

        throw_unless($this->showCancelButton(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        throw_unless($order->markAsCanceled(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        flash()->success(lang('igniter.cart::default.orders.alert_cancel_success'));
    }

    protected function getUnavailableReorderItems($order, CartManager $cartManager): array
    {
        $unavailable = [];

        foreach ($order->getOrderMenus() as $orderMenu) {
            if (!$menu = $orderMenu->menu) {
                $unavailable[] = $orderMenu->name;
                continue;
            }

            try {
                $cartManager->validateCartMenuItem($menu, $orderMenu->quantity);
            } catch (Throwable $ex) {
                $unavailable[] = trim(strip_tags($ex->getMessage()));
                continue;
            }

            $currentMenuOptions = $menu->menu_options->keyBy('menu_option_id');
            $savedOptionGroups = $orderMenu->menu_options->groupBy('menu_option_id');
            $historicalOptionNames = $this->getHistoricalOptionNames($orderMenu);
            $resolvedSelections = [];
            $hasUnavailableSavedSelection = false;

            foreach ($savedOptionGroups as $menuOptionId => $savedValues) {
                $historicalOptionName = $historicalOptionNames->get((string)$menuOptionId);
                $menuOption = $this->resolveCurrentMenuOption(
                    $currentMenuOptions,
                    (int)$menuOptionId,
                    $historicalOptionName,
                );

                if (!$menuOption) {
                    $hasUnavailableSavedSelection = true;
                    foreach ($savedValues as $savedValue) {
                        $detail = $historicalOptionName
                            ? $historicalOptionName.': '.$savedValue->order_option_name
                            : $savedValue->order_option_name;
                        $unavailable[] = $orderMenu->name.' – '.$detail;
                    }
                    continue;
                }

                foreach ($savedValues as $savedValue) {
                    $currentValue = $this->resolveCurrentMenuOptionValue($menuOption, $savedValue);
                    if (!$currentValue) {
                        $hasUnavailableSavedSelection = true;
                        $unavailable[] = $orderMenu->name.' – '.$menuOption->option_name.': '.$savedValue->order_option_name;
                        continue;
                    }

                    $resolvedSelections[$menuOption->getKey()][] = [
                        'id' => (int)$currentValue->menu_option_value_id,
                        'qty' => max(1, (int)($savedValue->quantity ?? 1)),
                        'name' => $currentValue->name,
                    ];
                }
            }

            // A missing historical selection already explains why this menu can not be reordered.
            // Avoid adding secondary "required option" messages for the same menu.
            if ($hasUnavailableSavedSelection) {
                continue;
            }

            // Also validate the current option requirements. This catches a menu that gained a new
            // required option, or whose min/max selection rules changed after the historical order.
            foreach ($currentMenuOptions as $menuOptionId => $menuOption) {
                try {
                    $cartManager->validateMenuItemOption(
                        $menuOption,
                        $resolvedSelections[$menuOptionId] ?? [],
                    );
                } catch (Throwable $ex) {
                    $unavailable[] = $orderMenu->name.' – '.trim(strip_tags($ex->getMessage()));
                }
            }
        }

        return array_values(array_unique(array_filter($unavailable)));
    }

    protected function formatUnavailableReorderMessage(array $items): string
    {
        $grouped = [];

        foreach (array_unique(array_filter(array_map(
            fn($item): string => trim(strip_tags((string)$item)),
            $items,
        ))) as $item) {
            [$menuName, $detail] = array_pad(explode(' – ', $item, 2), 2, null);
            $menuName = trim($menuName);

            if (!$detail) {
                $grouped[$menuName] ??= [];
                continue;
            }

            $grouped[$menuName][] = trim($detail);
        }

        $details = collect($grouped)
            ->map(function(array $menuDetails, string $menuName): string {
                $menuDetails = array_values(array_unique(array_filter($menuDetails)));

                return $menuDetails === []
                    ? $menuName
                    : $menuName.' ('.implode(', ', $menuDetails).')';
            })
            ->values()
            ->implode('; ');

        $failedMessage = trim(str_before(lang('igniter.cart::default.orders.alert_reorder_failed'), '.'));
        $unavailableLabel = ucfirst(strtolower((string)lang('igniter.cart::default.text_is_unavailable')));

        return rtrim($failedMessage, '.').'. '.$unavailableLabel.': '.$details;
    }

    protected function normalizeHistoricalOrderOptions($order): void
    {
        foreach ($order->getOrderMenus() as $orderMenu) {
            if (!$orderMenu->menu || $orderMenu->menu_options->isEmpty()) {
                continue;
            }

            $currentMenuOptions = $orderMenu->menu->menu_options->keyBy('menu_option_id');
            $historicalOptionNames = $this->getHistoricalOptionNames($orderMenu);

            $orderMenu->option_values = $orderMenu->menu_options
                ->groupBy('menu_option_id')
                ->map(function($savedValues, $menuOptionId) use ($currentMenuOptions, $historicalOptionNames): ?array {
                    $menuOption = $this->resolveCurrentMenuOption(
                        $currentMenuOptions,
                        (int)$menuOptionId,
                        $historicalOptionNames->get((string)$menuOptionId),
                    );

                    if (!$menuOption) {
                        return null;
                    }

                    $values = $savedValues
                        ->map(function($savedValue) use ($menuOption): ?CartItemOptionValue {
                            $currentValue = $this->resolveCurrentMenuOptionValue($menuOption, $savedValue);
                            if (!$currentValue) {
                                return null;
                            }

                            return CartItemOptionValue::fromArray([
                                'id' => (int)$currentValue->menu_option_value_id,
                                'qty' => max(1, (int)($savedValue->quantity ?? 1)),
                                'name' => $currentValue->name,
                                'price' => (float)$savedValue->order_option_price,
                                'free_qty' => (int)($savedValue->free_qty ?? 0),
                            ]);
                        })
                        ->filter()
                        ->values()
                        ->all();

                    return [
                        'id' => (int)$menuOption->menu_option_id,
                        'name' => $menuOption->option_name,
                        'values' => CartItemOptionValues::make($values),
                    ];
                })
                ->filter()
                ->values()
                ->all();
        }
    }

    protected function getHistoricalOptionNames($orderMenu)
    {
        return collect($orderMenu->option_values ?? [])
            ->mapWithKeys(function($menuOption, $optionKey): array {
                $menuOptionId = data_get($menuOption, 'id')
                    ?? (is_numeric($optionKey) ? (int)$optionKey : null);
                $menuOptionName = trim((string)data_get($menuOption, 'name', ''));

                return $menuOptionId && $menuOptionName !== ''
                    ? [(string)$menuOptionId => $menuOptionName]
                    : [];
            });
    }

    protected function resolveCurrentMenuOption($currentMenuOptions, int $historicalId, ?string $historicalName)
    {
        if ($menuOption = $currentMenuOptions->get($historicalId)) {
            return $menuOption;
        }

        $historicalName = trim((string)$historicalName);
        if ($historicalName === '') {
            return null;
        }

        return $currentMenuOptions->first(fn($menuOption): bool =>
            strcasecmp(trim((string)$menuOption->option_name), $historicalName) === 0,
        );
    }

    protected function resolveCurrentMenuOptionValue($menuOption, $savedValue)
    {
        $historicalId = (int)$savedValue->menu_option_value_id;
        if ($currentValue = $menuOption->menu_option_values->first(fn($value): bool =>
            (int)$value->menu_option_value_id === $historicalId,
        )) {
            return $currentValue;
        }

        $historicalName = trim((string)$savedValue->order_option_name);
        if ($historicalName === '') {
            return null;
        }

        return $menuOption->menu_option_values->first(fn($value): bool =>
            strcasecmp(trim((string)$value->name), $historicalName) === 0,
        );
    }

    protected function getProcessedOrder()
    {
        if (!$this->hash) {
            return null;
        }

        if (!is_null($this->order)) {
            return $this->order;
        }

        $order = $this->orderManager->getOrderByHash($this->hash, Auth::customer());
        if (!$order?->isPaymentProcessed()) {
            return null;
        }

        return $this->order = $order;
    }

    protected function getLoginPageUrl(): string
    {
        $currentUrl = str_after(request()->fullUrl(), request()->root());

        return page_url($this->loginPage).'?redirect='.urlencode($currentUrl);
    }
}
