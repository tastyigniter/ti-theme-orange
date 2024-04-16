<?php

namespace Igniter\FrontEnd\Database\Migrations;

use Igniter\Frontend\Models\Slider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    public function up()
    {
        Schema::create('igniter_frontend_sliders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique()->index();
            $table->text('metadata')->nullable();
            $table->timestamps();
        });

        $this->seedSlider();
    }

    public function down()
    {
        Schema::dropIfExists('igniter_frontend_sliders');
    }

    protected function seedSlider()
    {
        $slider = $this->getSlider();
        $data = array_get((array)$slider, 'data');
        if (!is_array($data)) {
            $data = unserialize($data);
        }

        $model = Slider::create([
            'name' => array_get($slider, 'name', 'Homepage slider'),
            'code' => array_get($slider, 'code', 'home-slider'),
        ]);

        if (!$items = array_get($data, 'images', [])) {
            return;
        }

        optional($model->images)->each(function ($media) {
            $media->delete();
        });

        foreach ($items as $item) {
            $this->createMediaAttachment($item, $model, 'images');
        }
    }

    protected function getSlider()
    {
        $existingSlider = DB::table('extension_settings')->select('data')
            ->where('item', 'igniter_frontend_slidersettings')->first();
        if (!$existingSlider) {
            return [
                'name' => 'Homepage slider',
                'code' => 'home-slider',
                'data' => [
                    'images' => [
                        dirname(__DIR__, 2).'/assets/images/slide.png',
                    ],
                ],
            ];
        }

        return $existingSlider;
    }

    protected function createMediaAttachment($path, $model, $tagName)
    {
        try {
            if (!starts_with($path, base_path())) {
                $path = uploads_path($path);
            }

            if (!file_exists($path)) {
                $path = dirname(__DIR__, 2).'/assets/images/slide.png';
            }

            $media = $model->newMediaInstance();
            $media->addFromFile($path, $tagName);

            $media->save();
            $model->media()->save($media);
        } catch (\Exception $ex) {
            Log::error($ex);
        }
    }
}
