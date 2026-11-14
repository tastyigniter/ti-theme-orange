<?php

declare(strict_types=1);

namespace Igniter\Orange\Blocks;

use Igniter\Flame\Support\Facades\File;
use Igniter\Main\Classes\BaseBlock;

/**
 * Page builder blocks provided by the Orange theme.
 *
 * Content blocks render the theme `_builder/blocks/{code}` views. Component
 * blocks wrap the theme Livewire and Blade components, their settings come
 * from each component's defineProperties().
 */
class OrangeBlocks
{
    /**
     * @return list<BaseBlock|class-string<BaseBlock>>
     */
    public static function definitions(): array
    {
        return array_merge(self::contentBlocks(), self::componentBlocks());
    }

    /**
     * @return list<class-string<BaseBlock>>
     */
    public static function contentBlocks(): array
    {
        return [
            Heading::class,
            RichText::class,
            Image::class,
            ImageText::class,
            CallToAction::class,
            Html::class,
            Spacer::class,
            BackLink::class,
            AccountNav::class,
        ];
    }

    /**
     * @return list<OrangeComponentBlock>
     */
    public static function componentBlocks(): array
    {
        $blocks = [];
        foreach (self::componentDetails() as $componentCode => $details) {
            $blocks[] = $componentCode === 'igniter-orange::fulfillment'
                ? FulfillmentBlock::make($componentCode, $details)
                : OrangeComponentBlock::make($componentCode, $details);
        }

        return $blocks;
    }

    public static function componentDetails(): array
    {
        $configFile = __DIR__.'/../../resources/meta/builder.php';
        $config = File::exists($configFile) ? (array)File::getRequire($configFile) : [];

        return array_get($config, 'blocks', []);
    }
}
