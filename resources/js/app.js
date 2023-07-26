import './bootstrap';
import 'livewire-sortable'
import Alpine from 'alpinejs';
import Swal from "sweetalert2";
import $ from 'jquery'
import select2 from 'select2'

select2($)
window.Alpine = Alpine;

Alpine.start();
window.Swal = Swal;
