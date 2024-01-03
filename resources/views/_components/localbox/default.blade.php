@if ($location->current())
    <div class="panel panel-local">
        <div class="panel-body">
            <div class="row boxes">
                <div class="box-one col-sm-6">
                    @themePartial('@box_one')
                </div>
                <div class="box-divider d-block d-sm-none"></div>
                <div id="local-box-two" class="box-two col-sm-6">
                    @themePartial('@box_two')
                </div>
            </div>
        </div>
    </div>
@endif
