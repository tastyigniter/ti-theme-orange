<?= get_script_tags(['ui', 'widget', 'component', 'custom', 'theme']); ?>
<?= $this->theme->ga_tracking_code; ?>
<?php if (empty($this->theme->custom_js)) { ?>
    <?= '<script type="text/javascript">'.$this->theme->custom_js.'</script>' ?>
<?php } ?>
