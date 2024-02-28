<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Models\Location;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Contact extends Component
{
    #[Validate('required|max:128', as: 'igniter.frontend::default.contact.text_select_subject')]
    public $subject;

    #[Validate('required|email:filter|max:96', as: 'igniter.frontend::default.contact.label_email')]
    public $email;

    #[Validate('required|min:2|max:255', as: 'igniter.frontend::default.contact.label_full_name')]
    public $fullName;

    #[Rule('required', as: 'igniter.frontend::default.contact.label_telephone')]
    public $telephone;

    #[Validate('max:1500', as: 'igniter.frontend::default.contact.label_comment')]
    public $comment;

    public $subjects = [
        'igniter.frontend::default.contact.text_general_enquiry',
        'igniter.frontend::default.contact.text_comment',
        'igniter.frontend::default.contact.text_technical_issues',
    ];

    public ?string $message = null;

    public function render()
    {
        return view('igniter-orange::livewire.contact', [
            'locationDefault' => Location::getDefault(),
        ]);
    }

    public function onSubmit()
    {
        $this->validate();

        $data = [
            'full_name' => $this->fullName,
            'contact_topic' => $this->subject,
            'contact_email' => $this->email,
            'contact_telephone' => $this->telephone,
            'contact_message' => $this->comment,
        ];

        Mail::queueTemplate('igniter.frontend::mail.contact', $data, [
            setting('site_email'), setting('site_name'),
        ]);

        $this->reset();

        $this->message = lang('igniter.frontend::default.contact.alert_contact_sent');
    }
}
