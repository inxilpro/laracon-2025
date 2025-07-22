import { icon, map as createMap, marker, tileLayer } from 'leaflet/dist/leaflet-src.esm.js';
import cup_pin from '../../public/cup@2x.png';
import laracon_pin from '../../public/laracon-pin@2x.png';
import laracon_pin_shadow from '../../public/laracon-pin-shadow@2x.png';

const node = document.getElementById('map');

const map = createMap(node, {
	zoomDelta: 3,
}).setView([39.645776, -104.800734], 5);

window.addEventListener('invalidatemapsize', () => {
	setTimeout(() => map.invalidateSize({ debounceMoveend: true }), 1);
});

tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
	maxZoom: 15,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> + <a href="https://carto.com/attributions">CARTO</a>'
}).addTo(map);

const events = JSON.parse(node.dataset.map);

const LaraconIcon = icon({
	iconUrl: laracon_pin,
	iconSize: [25, 34],
	iconAnchor: [22, 33],
	shadowUrl: laracon_pin_shadow,
	shadowSize: [40, 34],
});

const CoffeeCupIcon = icon({
	iconUrl: cup_pin,
	iconSize: [22, 25],
	iconAnchor: [11, 13],
});

events.forEach((event) => {
	marker([event.location.latitude, event.location.longitude], {
		title: event.title,
		icon: LaraconIcon,
		zIndexOffset: 1000,
	}).addTo(map);
	
	if ('coffee_shops' in event) {
		event.coffee_shops.forEach((tower) => {
			marker([tower.location.latitude, tower.location.longitude], {
				title: tower.radio,
				icon: CoffeeCupIcon,
			}).addTo(map);
		});
	}
});
