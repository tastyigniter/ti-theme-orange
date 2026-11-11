<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Igniter\Main\Classes\ComponentBlock;
use Override;

/**
 * Component block with Orange presentation options: show the component in a
 * card and add CSS classes to its wrapper. These settings are not passed to
 * the component.
 */
class OrangeComponentBlock extends ComponentBlock
{
    public const array WRAPPER_FIELDS = ['wrapper_card', 'wrapper_class'];

    #[Override]
    public function defineFields(): array
    {
        return array_merge(parent::defineFields(), [
            'wrapper_card' => [
                'label' => 'igniter.orange::default.builder.label_wrapper_card',
                'type' => 'switch',
                'span' => 'left',
                'default' => false,
            ],
            'wrapper_class' => [
                'label' => 'igniter.orange::default.builder.label_wrapper_class',
                'type' => 'text',
                'span' => 'right',
                'validationRule' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z0-9_\-\s]*$/'],
            ],
        ]);
    }

    #[Override]
    public function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'wrapper_card' => false,
            'wrapper_class' => null,
        ]);
    }

    #[Override]
    public function summary(array $settings): string
    {
        return parent::summary(array_except($settings, self::WRAPPER_FIELDS));
    }

    #[Override]
    public function render(string $viewNamespace, array $block): string
    {
        $settings = $block['settings'] ?? [];
        $block['settings'] = array_except($settings, self::WRAPPER_FIELDS);

        $html = parent::render($viewNamespace, $block);

        $class = trim((string)preg_replace('/[^A-Za-z0-9_\-\s]/', '', (string)($settings['wrapper_class'] ?? '')));

        if (!empty($settings['wrapper_card'])) {
            return sprintf('<div class="card mb-3 %s"><div class="card-body">%s</div></div>', e($class), $html);
        }

        return $class !== '' ? sprintf('<div class="%s">%s</div>', e($class), $html) : $html;
    }
}
