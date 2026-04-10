import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

import { accordion } from './components/accordion';
import { alertDialog } from './components/alert_dialog';
import { calendar } from './components/calendar';

import.meta.glob(['../images/**', '../fonts/**']);

Alpine.plugin(focus);

// Initialize Window
window.Alpine = Alpine;

Alpine.data('accordion', accordion);
Alpine.data('alertDialog', alertDialog);
Alpine.data('calendar', calendar);

Alpine.start();
