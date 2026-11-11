<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Igniter\Main\Template\Page;
use Override;

class BackLink extends ContentBlock
{
    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'back-link',
            'name' => 'igniter.orange::default.builder.block_back_link',
            'description' => 'igniter.orange::default.builder.block_back_link_desc',
            'icon' => 'fa fa-arrow-left-long',
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return [
            'text' => [
                'label' => 'igniter.orange::default.builder.label_text',
                'type' => 'text',
                'span' => 'left',
                'default' => 'igniter.orange::default.button_back',
                'validationRule' => ['required', 'string', 'max:255'],
            ],
            'page' => [
                'label' => 'igniter.orange::default.builder.label_page',
                'type' => 'select',
                'span' => 'right',
                'default' => 'home',
                'options' => fn(): array => Page::getDropdownOptions(),
                'validationRule' => ['required', 'regex:/^[a-z0-9\-_\.]+$/i'],
            ],
        ];
    }

    #[Override]
    public function summary(array $settings): string
    {
        return lang((string)$settings['text']).' → '.$settings['page'];
    }
}
