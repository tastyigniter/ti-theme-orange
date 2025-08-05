window.OrangeFulfillment = (timeslot) => {
    let map = null;
    return {
        orderDate: null,
        orderTime: null,
        timeslot: timeslot,
        hideDeliveryAddress: false,
        showTimePicker: false,
        marker: null,
        mapKey: null,
        init() {
            this.mapKey = this.$wire.mapKey
            this.orderDate = this.$wire.get('orderDate');
            this.orderTime = this.$wire.get('orderTime');

            this.hideDeliveryAddress = this.$wire.get('orderType') !== 'delivery';
            this.showTimePicker = !this.$wire.get('previewMode') && this.$wire.get('isAsap') == 0;

            this.$wire.$watch('orderDate', value => {
                this.orderDate = value;
            });

            this.$wire.$watch('orderType', value => {
                this.hideDeliveryAddress = value !== 'delivery';
            });

            this.$wire.$watch('isAsap', value => {
                this.showTimePicker = value == 0;
            });
            this.$wire.on('initializeDeliveryLocationMap', ({ lat, lng}) => {
                if(!map) {
                    setTimeout(() => {
                        this.initializeMap(this.getPosition(lat, lng));
                    }, 500)
                } else {
                    map.setCenter(this.getPosition(lat, lng));
                    this.marker.position = this.getPosition(lat, lng);
                }
            });
        },
        async initializeMap(position = "") {
            (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
            ({key: this.mapKey, v: "weekly"});

            const {Map} = await google.maps.importLibrary('maps');
            const {AdvancedMarkerElement} = await google.maps.importLibrary('marker');

            map = new Map(document.getElementById('map'), {
                zoom: 15,
                center: position,
                mapId: 'DEMO_MAP_ID',
                disableDefaultUI: true,
            });

            this.marker = new AdvancedMarkerElement({
                map,
                position,
                title: 'Delivery Location',
            });

            map.addListener('drag', () => {
                this.marker.position = map.getCenter();
            });
            map.addListener('dragend', () => {
                this.$wire.dispatch('userPositionUpdated', {
                    position: [ map.getCenter().lat(), map.getCenter().lng() ]
                });
            });
            map.addListener('click', (e) => {
                this.marker.position = e.latLng
                map.panTo(e.latLng);
                this.$wire.dispatch('userPositionUpdated', {
                    position: [ map.getCenter().lat(), map.getCenter().lng() ]
                });
            });
        },
        getPosition(lat, lng) {
            if (!lat || !lng) {
                return null;
            }
            return {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };
        }
    };
}
