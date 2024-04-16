<?php

return [

    'text_side_menu' => 'Sliders & Banners',

    'banners' => [
        'text_tab_general' => 'General',
        'component_title' => 'Banner Component',
        'component_desc' => 'Displays banners',
        'text_edit_banner' => 'Edit Banner',
        'text_title' => 'Banners',
        'text_form_name' => 'Banner',
        'text_filter_search' => 'Search by name, type or status.',
        'text_empty' => 'There are no banners available.',
        'text_image' => 'Image',
        'text_custom' => 'Custom',

        'column_banner' => 'Banner',
        'column_dimension' => 'Dimension (W x H)',
        'column_layout_partial' => 'Layout - Partial Area',
        'column_status' => 'Status',
        'column_id' => 'ID',

        'label_banner' => 'Banner',
        'label_dimension' => 'Dimension (W x H)',
        'label_width' => 'Width',
        'label_height' => 'Height',
        'label_status' => 'Status',
        'label_layout_partial' => 'Layout - Partial Area',
        'label_type' => 'Type',
        'label_click_url' => 'Click URL',
        'label_language' => 'Language',
        'label_alt_text' => 'Alternative Text',
        'label_image' => 'Image',
        'label_custom_code' => 'Custom Code',

        'button_banners' => 'Add New Banner',

        'help_layouts' => 'Choose a layout to add one or more banner(s).',
        'help_image' => 'Choose multiple images to display banner as carousel',
        'help_click_url' => 'You can use a relative or absolute site URL',

        'alert_set_banners' => 'You must first add the banners module to one or more layouts',
    ],

    'contact' => [
        'component_title' => 'Contact Form Component',
        'component_desc' => 'Displays Contact form',
        'text_heading' => 'Contact',
        'text_summary' => 'Feel free to send a message',
        'text_find_us' => 'Find Us On Map',
        'text_select_subject' => 'select a subject',
        'text_contact_us' => 'Contact Us',
        'text_general_enquiry' => 'General enquiry',
        'text_comment' => 'Comment',
        'text_technical_issues' => 'Technical Issues',

        'label_subject' => 'Enquiry Subject:',
        'label_full_name' => 'Full Name:',
        'label_email' => 'Email Address:',
        'label_telephone' => 'Telephone:',
        'label_comment' => 'Comment',

        'button_send' => 'SEND',

        'alert_contact_sent' => 'Message Sent successfully, we will get back to you shortly!',
    ],

    'slider' => [
        'text_title' => 'Sliders',
        'text_tab_general' => 'General',
        'component_title' => 'Slider Component',
        'component_desc' => 'Displays images slider on homepage',
        'text_form_name' => 'Slider',
        'text_empty' => 'There are no sliders available.',

        'text_tab_slides' => 'Slides',

        'column_updated_at' => 'Updated',

        'label_code' => 'Code',
        'label_slider' => 'Slider code',
        'label_effect' => 'Effects',
        'label_interval' => 'Delay interval between slides',
        'label_caption' => 'Caption',
        'label_images' => 'Images',
        'label_hide_controls' => 'Hide Controls',
        'label_hide_indicators' => 'Hide Indicators',
        'label_hide_captions' => 'Hide Captions',
    ],

    'newsletter' => [
        'text_tab_general' => 'General',
        'component_title' => 'Newsletter Component',
        'component_desc' => 'Displays the subscribe to newsletter form',

        'text_subscribe' => 'Subscribe to our newsletter',

        'label_status' => 'Status:',
        'label_email' => 'Email',

        'alert_success_subscribed' => 'Thanks, Your email now subscribed for our offers',
        'alert_success_existing' => 'Thanks, Your email already subscribed for our offers',
    ],

    'featured' => [
        'text_tab_general' => 'General',
        'component_title' => 'Featured Menu Component',
        'component_desc' => 'Displays list of featured menus on the store front',
        'text_subscribe' => 'Subscribe to our newsletter',
        'text_featured_menus' => 'Featured Menu',

        'column_menu_name' => 'Menu Name',
        'column_menu_remove' => 'Remove',

        'label_title' => 'Title',
        'label_menus' => 'Menus',
        'label_limit' => 'Limit',
        'label_items_per_row' => 'Items per row',
        'label_dimension' => 'Dimension:',
        'label_dimension_w' => 'Dimension Width',
        'label_dimension_h' => 'Dimension Height',

        'help_dimension' => '(Width x Height)',
        'help_items_per_row' => 'The number of items to display per row',
    ],

    'captcha' => [
        'component_title' => 'Captcha Component',
        'component_desc' => 'Displays the reCATPCHA widget.',

        'label_api_site_key' => 'Site Key',
        'label_api_secret_key' => 'Secret Key',
        'label_version' => 'Version',
        'label_version_v2' => 'reCAPTCHA v2',
        'label_version_invisible' => 'reCAPTCHA v2 Invisible',
        'label_version_v3' => 'reCAPTCHA v3',
        'label_lang' => 'Language',

        'error_recaptcha' => 'Please confirm you are human!',

        'help_lang' => 'Forces the widget to render in a specific language. Auto - detects the user\'s language if unspecified.',
    ],
];
