<div class="row-fluid">
    {!! form_open([
        'id' => 'form-widget',
        'role' => 'form',
        'accept-charset' => 'utf-8',
        'method' => 'POST',
    ]) !!}

    {!! $this->renderForm() !!}

    {!! form_close() !!}
</div>
