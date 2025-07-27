import { icon, map as createMap, marker, tileLayer, popup } from 'leaflet/dist/leaflet-src.esm.js';
import cup_pin from '../../public/cone@2x.png';
import laracon_pin from '../../public/laracon-pin@2x.png';
import laracon_prediction_pin from '../../public/laracon-prediction-pin@2x.png';
import laracon_pin_shadow from '../../public/laracon-pin-shadow@2x.png';

const node = document.getElementById('map');

const map = createMap(node, {
	// zoomDelta: 3,
	// zoomSnap: 3,
}).setView([39.82818, -98.5795], 5);

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
	iconAnchor: [13, 20],
	shadowUrl: laracon_pin_shadow,
	shadowSize: [40, 34],
});

const LaraconPredictionIcon = icon({
	iconUrl: laracon_prediction_pin,
	iconSize: [25, 34],
	iconAnchor: [13, 20],
	shadowUrl: laracon_pin_shadow,
	shadowSize: [40, 34],
});

const CoffeeCupIcon = icon({
	iconUrl: cup_pin,
	iconSize: [25, 34],
	iconAnchor: [13, 20],
});

events.forEach((event) => {
	const coords = [event.location.latitude, event.location.longitude];
	const label = popup()
		.setLatLng(coords)
		.setContent(event.title);
	
	marker(coords, {
		title: event.title,
		icon: event.exists ? LaraconIcon : LaraconPredictionIcon,
		zIndexOffset: 1000,
	})
		.on('click', () => {
			const zoom = map.getZoom() > 10 ? 5 : 15;
			map.setView(coords, zoom);
			if (15 === zoom) {
				label.openOn(map);
			}
		})
		.addTo(map);
	
	if ('ice_cream_shops' in event) {
		event.ice_cream_shops.forEach((tower) => {
			marker([tower.location.latitude, tower.location.longitude], {
				title: tower.radio,
				icon: CoffeeCupIcon,
			}).addTo(map);
		});
	}
});
