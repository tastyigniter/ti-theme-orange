<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class CallToAction extends ContentBlock
{
    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'call-to-action',
            'name' => 'igniter.orange::default.builder.block_call_to_action',
            'description' => 'igniter.orange::default.builder.block_call_to_action_desc',
            'icon' => 'fa fa-bullhorn',
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return array_merge([
            'title' => [
                'label' => 'igniter.orange::default.builder.label_title',
                'type' => 'text',
                'validationRule' => ['required', 'string', 'max:255'],
            ],
            'text' => [
                'label' => 'igniter.orange::default.builder.label_text',
                'type' => 'textarea',
                'validationRule' => ['nullable', 'string', 'max:1000'],
            ],
        ], $this->buttonFields(), [
            'style' => [
                'label' => 'igniter.orange::default.builder.label_style',
                'type' => 'radiotoggle',
                'default' => 'primary',
                'options' => [
                    'primary' => 'igniter.orange::default.builder.text_style_primary',
                    'light' => 'igniter.orange::default.builder.text_style_light',
                    'dark' => 'igniter.orange::default.builder.text_style_dark',
                ],
                'validationRule' => ['in:primary,light,dark'],
            ],
            'alignment' => $this->alignmentField(),
        ]);
    }
}
