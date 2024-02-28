<div>
    <div class="card mb-3">
        @if ($locationDefault)
            <div class="card-body">
                <h1 class="h3 card-title">{{ $locationDefault->getName() }}</h1>
                <div class="row contact-info mb-2">
                    <div class="col-1"><i class="fa fa-globe"></i></div>
                    <div class="col">{{format_address($locationDefault->getAddress())}}</div>
                </div>
                <div class="row contact-info">
                    <div class="col-1"><i class="fa fa-phone"></i></div>
                    <div class="col">{{ $locationDefault->getTelephone() }}</div>
                </div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="contact-title mb-3">@lang('igniter.frontend::default.contact.text_summary')</h4>
            @if($message)
                <p>{{$message}}</p>
            @else
                <x-igniter-orange::forms.form id="contact-form" wire:submit="onSubmit">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <div @class(['form-floating', 'is-invalid' => has_form_error('subject')])>
                                    <select
                                        wire:model="subject"
                                        name="subject"
                                        class="form-select"
                                    >
                                        <option>@lang('igniter.frontend::default.contact.text_select_subject')</option>
                                        @foreach ($subjects as $subject)
                                            <option value="@lang($subject)">@lang($subject)</option>
                                        @endforeach
                                    </select>
                                    <label
                                        for="subject">@lang('igniter.frontend::default.contact.label_subject')</label>
                                </div>
                                <x-igniter-orange::forms.error field="subject" class="text-danger"/>
                            </div>
                            <div class="form-group">
                                <div @class(['form-floating', 'is-invalid' => has_form_error('email')])>
                                    <input
                                        wire:model="email"
                                        type="text"
                                        name="email"
                                        class="form-control"
                                    />
                                    <label for="email">@lang('igniter.frontend::default.contact.label_email')</label>
                                </div>
                                <x-igniter-orange::forms.error field="email" class="text-danger"/>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <div @class(['form-floating', 'is-invalid' => has_form_error('full_name')])>
                                    <input
                                        wire:model="fullName"
                                        type="text"
                                        name="fullName"
                                        class="form-control"
                                    />
                                    <label
                                        for="fullName">@lang('igniter.frontend::default.contact.label_full_name')</label>
                                </div>
                                <x-igniter-orange::forms.error field="fullName" class="text-danger"/>
                            </div>
                            <div class="form-group">
                                <div @class(['form-floating', 'is-invalid' => has_form_error('telephone')])>
                                    <input
                                        wire:model="telephone"
                                        type="text"
                                        name="telephone"
                                        class="form-control"
                                    />
                                    <label
                                        for="telephone">@lang('igniter.frontend::default.contact.label_telephone')</label>
                                </div>
                                <x-igniter-orange::forms.error field="telephone" class="text-danger"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div @class(['form-floating', 'is-invalid' => has_form_error('telephone')])>
                            <textarea
                                wire:model="comment"
                                name="comment"
                                class="form-control"
                                rows="5"
                            ></textarea>
                            <label for="telephone">@lang('igniter.frontend::default.contact.label_comment')</label>
                        </div>
                        <x-igniter-orange::forms.error field="comment" class="text-danger"/>
                    </div>

                    <div class="buttons">
                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >@lang('igniter.frontend::default.contact.button_send')</button>
                    </div>
                </x-igniter-orange::forms.form>
            @endif
        </div>
    </div>
</div>
