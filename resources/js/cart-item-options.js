window.OrangeCartItemOptions = (min, max) => {
    return {
        minSelection: min,
        maxSelection: max,
        toggleSelection() {
            if (this.maxSelection <= 0)
                return;

            const selectedCount = this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:checked:not([disabled])').length;

            [...this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:not(:checked)')]
                .forEach(($el) => {
                    selectedCount === this.maxSelection ? $el.setAttribute('disabled', 'disabled') : $el.removeAttribute('disabled')
                })
        },
        init() {
            Livewire.on('cartItemTotalCalculated', () => {
                this.toggleSelection()
            })

            $(this.$el).on('click', '[data-toggle="more-options"], [data-toggle="less-options"]', function (event) {
                var $el = $(event.currentTarget),
                    $container = $el.closest('[data-control="item-option"]')

                if ($el.data('toggle') == 'more-options') {
                    $el.fadeOut()
                    $container.find('[data-toggle="less-options"]').fadeIn();
                    $container.find('.hidden-item-options').fadeIn();
                } else {
                    $el.fadeOut()
                    $container.find('[data-toggle="more-options"]').fadeIn();
                    $container.find('.hidden-item-options').fadeOut();
                }
            })
        }
    }
}
