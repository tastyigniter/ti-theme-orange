<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Override;

class Image extends ContentBlock
{
    #[Override]
    public function blockDetails(): array
    {
        return [
            'code' => 'image',
            'name' => 'igniter.orange::default.builder.block_image',
            'description' => 'igniter.orange::default.builder.block_image_desc',
            'icon' => 'fa fa-image',
        ];
    }

    #[Override]
    public function defineFields(): array
    {
        return [
            'image' => [
                'label' => 'igniter.orange::default.builder.label_image',
                'type' => 'mediafinder',
                'validationRule' => ['required', 'string'],
            ],
            'alt' => [
                'label' => 'igniter.orange::default.builder.label_alt_text',
                'type' => 'text',
                'span' => 'left',
                'validationRule' => ['nullable', 'string', 'max:255'],
            ],
            'link' => [
                'label' => 'igniter.orange::default.builder.label_link',
                'type' => 'text',
                'span' => 'right',
                'validationRule' => ['nullable', 'string', 'max:255', 'regex:/^(\/|#|https?:\/\/)/i'],
            ],
            'rounded' => [
                'label' => 'igniter.orange::default.builder.label_rounded',
                'type' => 'switch',
                'default' => true,
            ],
        ];
    }

    #[Override]
    public function resolve(array $settings): array
    {
        return array_merge($settings, [
            'url' => $settings['image'] ? media_url($settings['image']) : null,
        ]);
    }

    #[Override]
    public function summary(array $settings): string
    {
        return (string)($settings['alt'] ?: $settings['image']);
    }
}
