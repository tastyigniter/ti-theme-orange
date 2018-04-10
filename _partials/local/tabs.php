<ul id="nav-tabs" class="nav nav-tabs nav-tabs-line nav-menus">
	<li class="<?= ($context === 'menus') ? 'active':''; ?>">
		<a href="<?= restaurant_url('local/menus'); ?>"><?= lang('sampoyigi.local::default.text_tab_menu'); ?></a>
	</li>
	<?php if (setting('allow_reviews', 1)) { ?>
		<li class="<?= ($context === 'reviews') ? 'active':''; ?>">
			<a href="<?= restaurant_url('local/reviews'); ?>"><?= lang('sampoyigi.local::default.text_tab_review'); ?></a>
		</li>
	<?php } ?>
	<li class="<?= ($context === 'info') ? 'active':''; ?>">
		<a href="<?= restaurant_url('local/info'); ?>"><?= lang('sampoyigi.local::default.text_tab_info'); ?></a>
	</li>
	<?php if ($currentLocation->hasGallery()) { ?>
		<li class="<?= ($context === 'gallery') ? 'active':''; ?>">
			<a href="<?= restaurant_url('local/gallery'); ?>"><?= lang('sampoyigi.local::default.text_tab_gallery'); ?></a>
		</li>
	<?php } ?>
</ul>