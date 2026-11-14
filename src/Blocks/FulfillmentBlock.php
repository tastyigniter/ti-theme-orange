<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Livewire\Livewire;
use Override;

/**
 * The fulfillment block opens the fulfillment modal to change the order type
 * and time, so it renders the modal with it, once per request.
 */
class FulfillmentBlock extends OrangeComponentBlock
{
    public const string MODAL_COMPONENT = 'igniter-orange::fulfillment-modal';

    protected const string RENDERED_FLAG = 'igniter.orange.fulfillmentModalRendered';

    #[Override]
    public function render(string $viewNamespace, array $block): string
    {
        $html = parent::render($viewNamespace, $block);

        if (request()->attributes->get(self::RENDERED_FLAG)) {
            return $html;
        }

        request()->attributes->set(self::RENDERED_FLAG, true);

        return $html.Livewire::mount(self::MODAL_COMPONENT);
    }
}
