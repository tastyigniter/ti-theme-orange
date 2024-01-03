@if (($galleryImages = array_get($gallery, 'images')) && count($galleryImages))
    <h1 class="h4"><b>{{ array_get($gallery, 'title') }}</b></h1>
    <p>{!! nl2br(array_get($gallery, 'description', '')) !!}</p><br/>
    <div class="row gallery">
        @foreach ($galleryImages as $media)
            <div class="col-sm-4">
                <img
                        class="img-fluid img-rounded"
                        src="{{ $media->getThumb() }}"
                />
                <div class="overlay">
                    <a
                            href="{{ $media->getPath() }}"
                            target="_blank"
                    ><i class="fa fa-eye"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>@lang('igniter.local::default.text_empty_gallery')</p>
@endif
