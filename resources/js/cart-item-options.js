window.OrangeCartItemOptions = (min, max, linkedValueIds = [], menuOptionId = null) => {
    return {
        minSelection: min,
        maxSelection: max,
        linkedValueIds,
        menuOptionId,
        isVisible() {
            if (!this.linkedValueIds.length) return true
            const menuOptions = Object.values(this.$wire.menuOptions ?? {})
            return menuOptions.some((opt) => {
                const vals = [].concat(opt?.option_values ?? [])
                return vals.some((v) => this.linkedValueIds.includes(+v))
            })
        },
        toggleSelection() {
            if (this.maxSelection <= 0)
                return

            const selectedCount = this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:checked:not([disabled])').length

            ;[...this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:not(:checked)')]
                .forEach(($el) => {
                    selectedCount === this.maxSelection ? $el.setAttribute('disabled', 'disabled') : $el.removeAttribute('disabled')
                })
        },
        init() {
            if (this.linkedValueIds.length && this.menuOptionId !== null) {
                this.$watch(() => this.isVisible(), (visible) => {
                    if (!visible) {
                        this.$wire.set(`menuOptions.${this.menuOptionId}.option_values`, [], false)
                    }
                })
            }

            Livewire.on('cartItemTotalCalculated', () => {
                this.toggleSelection()
            })

            $(this.$el).on('click', '[data-toggle="more-options"], [data-toggle="less-options"]', function (event) {
                var $el = $(event.currentTarget),
                    $container = $el.closest('[data-control="item-option"]')

                if ($el.data('toggle') == 'more-options') {
                    $el.fadeOut()
                    $container.find('[data-toggle="less-options"]').fadeIn()
                    $container.find('.hidden-item-options').fadeIn()
                } else {
                    $el.fadeOut()
                    $container.find('[data-toggle="more-options"]').fadeIn()
                    $container.find('.hidden-item-options').fadeOut()
                }
            })
        }
    }
}
