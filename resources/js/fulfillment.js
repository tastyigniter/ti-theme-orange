window.OrangeFulfillment = (timeslot) => {
    return {
        orderDate: null,
        orderTime: null,
        timeslot: timeslot,
        hideDeliveryAddress: false,
        showTimePicker: false,
        init() {
            this.orderDate = this.$wire.get('orderDate');
            this.orderTime = this.$wire.get('orderTime');

            this.hideDeliveryAddress = this.$wire.get('orderType') !== 'delivery';
            this.showTimePicker = this.$wire.get('isAsap') == 0;

            this.$wire.$watch('orderDate', value => {
                this.orderDate = value;
            });

            this.$wire.$watch('orderType', value => {
                this.hideDeliveryAddress = value !== 'delivery';
            });

            this.$wire.$watch('isAsap', value => {
                this.showTimePicker = value == 0;
            });
        }
    };
}
