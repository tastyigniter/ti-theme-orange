<?php

namespace Igniter\Frontend\Components;

use Igniter\Frontend\Models\Slider as SliderModel;

class Slider extends \System\Classes\BaseComponent
{
    public $sliderName;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $sliderThumbs;

    public function defineProperties()
    {
        return [
            'code' => [
                'label' => 'lang:igniter.frontend::default.slider.label_slider',
                'type' => 'select',
                'validationRule' => 'required|alpha_dash',
            ],
            'height' => [
                'label' => 'lang:igniter.frontend::default.banners.label_height',
                'span' => 'left',
                'type' => 'text',
                'default' => '60vh',
                'validationRule' => 'string',
            ],
            'effect' => [
                'label' => 'lang:igniter.frontend::default.slider.label_effect',
                'span' => 'right',
                'type' => 'text',
                'default' => 'ease',
                'validationRule' => 'string',
            ],
            'delayInterval' => [
                'label' => 'lang:igniter.frontend::default.slider.label_interval',
                'span' => 'left',
                'type' => 'number',
                'default' => 5000,
            ],
            'hideControls' => [
                'label' => 'lang:igniter.frontend::default.slider.label_hide_controls',
                'span' => 'right',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideIndicators' => [
                'label' => 'lang:igniter.frontend::default.slider.label_hide_indicators',
                'span' => 'left',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideCaptions' => [
                'label' => 'lang:igniter.frontend::default.slider.label_hide_captions',
                'span' => 'right',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public static function getCodeOptions()
    {
        return SliderModel::lists('name', 'code')->all();
    }

    public function onRun()
    {
        $this->page['sliderSelectorId'] = 'slider-'.$this->property('code');
        $this->page['sliderHeight'] = $this->property('height');
        $this->page['sliderEffect'] = $this->property('effect');
        $this->page['sliderDelayInterval'] = $this->property('delayInterval');
        $this->page['showSliderControls'] = !(bool)$this->property('hideControls', false);
        $this->page['showSliderIndicators'] = !(bool)$this->property('hideIndicators', false);
        $this->page['showSliderCaptions'] = !(bool)$this->property('hideCaptions', false);

        $this->page['slides'] = $this->slides();
    }

    public function slides()
    {
        if (!is_null($this->sliderThumbs)) {
            return $this->sliderThumbs;
        }

        $code = $this->property('code');

        $this->sliderThumbs = [];

        if (strlen($code) && $slider = $this->getSlider()) {
            $this->sliderName = $slider->name;
            $this->sliderThumbs = $slider->images;
        }

        return $this->sliderThumbs;
    }

    /**
     * @return \Igniter\Frontend\Models\Slider
     */
    protected function getSlider()
    {
        return SliderModel::whereCode($this->property('code'))->first();
    }
}
