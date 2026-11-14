<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class Spacer extends ContentBlock
{
    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'spacer',
            'name' => 'igniter.orange::default.builder.block_spacer',
            'description' => 'igniter.orange::default.builder.block_spacer_desc',
            'icon' => 'fa fa-arrows-up-down',
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return [
            'size' => [
                'label' => 'igniter.orange::default.builder.label_size',
                'type' => 'radiotoggle',
                'default' => 'md',
                'options' => [
                    'sm' => 'igniter::main.builder.text_small',
                    'md' => 'igniter::main.builder.text_medium',
                    'lg' => 'igniter::main.builder.text_large',
                ],
                'validationRule' => ['in:sm,md,lg'],
            ],
            'divider' => [
                'label' => 'igniter.orange::default.builder.label_divider',
                'type' => 'switch',
                'default' => false,
            ],
        ];
    }

    #[Override]
    public function summary(array $settings): string
    {
        return '';
    }
}
