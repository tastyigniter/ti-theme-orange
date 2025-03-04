window.OrangeCartItem = () => {
    return {
        minQuantity: 1,
        quantity: 1,
        price: 0,
        total: 0,
        comment: null,
        incrementQuantity() {
            this.quantity = Math.max(this.minQuantity, this.quantity+this.minQuantity);
            this.$wire.set('quantity', this.quantity, false);
        },
        decrementQuantity() {
            this.quantity = Math.max(this.minQuantity, this.quantity-this.minQuantity);
            this.$wire.set('quantity', this.quantity, false);
        },
        calculateTotal() {
            var menuPrice = parseFloat(this.price);
            [...this.$refs['item-options']?.querySelectorAll('input[data-option-price]:checked:not([disabled]), select:not([disabled]) option[data-option-price]:checked')]
                .forEach((value, index) => {
                    menuPrice += parseFloat(value.dataset.optionPrice);
                });

            [...this.$refs['item-options']?.querySelectorAll('[data-option-quantity] input[data-option-price]:not([disabled])')]
                .forEach((value, index) => {
                    const quantity = parseInt(value._x_model?.get());
                    if (quantity > 0) {
                        menuPrice += (quantity * parseFloat(value.dataset.optionPrice));
                    }
                });

            this.total = app.currencyFormat(this.quantity * menuPrice);

            Livewire.dispatch('cartItemTotalCalculated')
        },
        init() {
            this.minQuantity = parseFloat(this.$wire.get('minQuantity'));
            this.price = parseFloat(this.$wire.get('price'));
            this.quantity = parseInt(this.$wire.get('quantity'));
            this.comment = this.$wire.get('comment');

            this.$nextTick(() => {
                this.calculateTotal();
            })

            this.$watch('quantity', value => {
                this.calculateTotal();
            })
        }
    };
}
