<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Igniter\Main\Classes\BaseBlock;
use Override;
use Stevebauman\Purify\Facades\Purify;

/**
 * Base class for Orange content blocks. Settings listed in $htmlFields are
 * cleaned with Purify before they are saved or rendered.
 */
abstract class ContentBlock extends BaseBlock
{
    /** @var list<string> */
    protected array $htmlFields = [];

    #[Override]
    public function sanitize(array $settings): array
    {
        $settings = parent::sanitize($settings);

        foreach ($this->htmlFields as $field) {
            if (isset($settings[$field]) && is_string($settings[$field])) {
                $config = $this->purifierConfig();
                $settings[$field] = $config ? Purify::config($config)->clean($settings[$field]) : Purify::clean($settings[$field]);
            }
        }

        return $settings;
    }

    /**
     * HTML Purifier settings for this block, null uses the application default.
     */
    protected function purifierConfig(): ?array
    {
        return null;
    }

    protected function alignmentField(): array
    {
        return [
            'label' => 'igniter.orange::default.builder.label_alignment',
            'type' => 'radiotoggle',
            'default' => 'start',
            'options' => [
                'start' => 'igniter.orange::default.builder.text_left',
                'center' => 'igniter.orange::default.builder.text_center',
                'end' => 'igniter.orange::default.builder.text_right',
            ],
        ];
    }

    protected function buttonFields(): array
    {
        return [
            'button_text' => [
                'label' => 'igniter.orange::default.builder.label_button_text',
                'type' => 'text',
                'span' => 'left',
            ],
            'button_link' => [
                'label' => 'igniter.orange::default.builder.label_button_link',
                'type' => 'text',
                'span' => 'right',
                'placeholder' => '/local/menus',
                'validationRule' => ['nullable', 'string', 'max:255', 'regex:/^(\/|#|https?:\/\/|mailto:|tel:)/i'],
            ],
        ];
    }
}
