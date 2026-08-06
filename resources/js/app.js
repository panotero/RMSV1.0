import Swiper from "swiper";
import { Navigation, Pagination, Zoom } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/zoom";
// import "flowbite";

window.Swiper = Swiper;
window.Navigation = Navigation;
window.Pagination = Pagination;
window.Zoom = Zoom;

import Alpine from "alpinejs";

window.Alpine = Alpine;

import Chart from "chart.js/auto";

window.Chart = Chart;

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

window.flatpickr = flatpickr;

Alpine.start();
import "./customFunctions";
import "./datatableHandler";
import "./apihandler";
import "./customAlert";
import "./navmenu";
import "./menuSettings";
import "./teamManagement";
import "./notificationController";
import "./mailer";
import "./toast";

import "./formatter";
import "./remoteTable";
