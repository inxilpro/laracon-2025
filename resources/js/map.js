import { map as createMap, icon, marker, tileLayer, Icon } from 'leaflet/dist/leaflet-src.esm.js';
import cell_tower_pin from '../../public/cell-pin@2x.png';
import laracon_pin from '../../public/laracon-pin@2x.png';
import laracon_pin_shadow from '../../public/laracon-pin-shadow@2x.png';

const node = document.getElementById('map');

const map = createMap(node).setView([39.645776, -104.800734], 5);

tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 15,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

const events = JSON.parse(node.dataset.map);
console.log({ events });

const LaraconPin = icon({
	iconUrl: laracon_pin,
	iconSize: [25, 34],
	iconAnchor: [22, 33],
	shadowUrl: laracon_pin_shadow,
	shadowSize: [40, 34],
});

const CellTowerPin = icon({
	iconUrl: cell_tower_pin,
	iconSize: [32, 34],
	iconAnchor: [16, 30],
});

events.forEach((event) => {
	marker([event.location.latitude, event.location.longitude], {
		title: event.title,
		icon: LaraconPin,
	}).addTo(map)
	
	event.cell_towers.forEach((tower) => {
		marker([tower.location.latitude, tower.location.longitude], {
			title: tower.radio,
			icon: CellTowerPin,
		}).addTo(map)
	});
});
