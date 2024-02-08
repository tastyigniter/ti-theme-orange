window.OrangeCartItemOptions = (min, max) => {
    return {
        minSelection: min,
        maxSelection: max,
        toggleSelection() {
            const $els = this.$refs['item-options']?.querySelectorAll('[data-control="item-option"]');

            if (!$els) {
                return
            }

            [...$els]
                .forEach((value, index) => {
                    if (this.maxSelection <= 0)
                        return;

                    const selectedCount = value.querySelectorAll('input[type="checkbox"][data-option-price]:checked:not([disabled])').length;

                    [...value.querySelectorAll('input[type="checkbox"][data-option-price]:not(:checked)')]
                        .forEach(($el) => {
                            $el.setAttribute('disabled', selectedCount === this.maxSelection)
                        })
                })
        },
        init() {
            Livewire.on('cartItemTotalCalculated', () => {
                this.toggleSelection()
            })
        }
    }
}
