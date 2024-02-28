window.OrangeOffcanvas = () => {
    return {
        show: false,
        showActiveComponent: true,
        activeOffcanvas: false,
        offcanvasHistory: [],
        offcanvasWidth: null,
        bsOffcanvas: null,
        closeOffcanvas(force = false, skipPrevious = 0, destroySkipped = false) {
            if (this.show === false) {
                return;
            }

            this.bsOffcanvas.dispose()
            Livewire.dispatch('destroyOffcanvas', {id: this.activeOffcanvas});

            // const id = this.offcanvasHistory.pop();
            //
            // if (id && !force) {
            //     if (id) {
            //         this.setActiveOffcanvasComponent(id, true);
            //     } else {
            //         this.setShowPropertyTo(false);
            //     }
            // } else {
            //     this.setShowPropertyTo(false);
            // }
        },
        setActiveOffcanvasComponent(id, skip = false) {
            this.setShowPropertyTo(true);

            if (this.activeOffcanvas === id) {
                return;
            }

            if (this.activeOffcanvas !== false && skip === false) {
                this.offcanvasHistory.push(this.activeOffcanvas);
            }

            let focusableTimeout = 50;

            if (this.activeOffcanvas === false) {
                this.activeOffcanvas = id
                this.showActiveComponent = true;
            } else {
                this.showActiveComponent = false;

                focusableTimeout = 400;

                setTimeout(() => {
                    this.activeOffcanvas = id;
                    this.showActiveComponent = true;
                }, 300);
            }

            this.$nextTick(() => {
                setTimeout(() => {
                    const offcanvasEl = $('#offcanvas-'+id+' .offcanvas')
                    this.bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl[0])
                    this.bsOffcanvas.show()

                    offcanvasEl.on('hidden.bs.offcanvas', event => {
                        Livewire.dispatch('closeOffcanvas');
                    })
                }, 300)

                let focusable = this.$refs[id]?.querySelector('[autofocus]');
                if (focusable) {
                    setTimeout(() => {
                        focusable.focus();
                    }, focusableTimeout);
                }
            });
        },
        setShowPropertyTo(show) {
            this.show = show;

            if (!show) {
                setTimeout(() => {
                    this.activeOffcanvas = false;
                    // this.$wire.resetState();
                }, 300);
            }
        },
        init() {
            Livewire.on('closeOffcanvas', (data) => {
                this.closeOffcanvas(data?.force ?? false, data?.skipPrevious ?? 0, data?.destroySkipped ?? false);
            });

            Livewire.on('activeOffcanvasComponentChanged', ({id}) => {
                this.setActiveOffcanvasComponent(id);
            });

            Livewire.on('openOffcanvas', () => {
                this.setShowPropertyTo(true);
            });
        }
    };
}
