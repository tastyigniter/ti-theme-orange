<form
    id="subscribeForm"
    class="subscribe-form"
    method="POST" data-request="<?= $subscribeHandler ?>">
    <div class="input-group subscribe-group">
        <input
            type="text"
            class="form-control"
            name="subscribe_email"
        >
        <span class="input-group-append">
            <button
                id="subscribeButton"
                class="btn btn-info"
            ><i class="fa fa-paper-plane"></i></button>
        </span>
    </div>
</form>