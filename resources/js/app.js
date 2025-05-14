import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Alpine from 'alpinejs'
import Swal from 'sweetalert2'
import Chart from 'chart.js/auto';

window.Swal = Swal;
window.Chart = Chart;
window.Alpine = Alpine;

Alpine.start()