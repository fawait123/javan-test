require('./bootstrap');

import { createApp } from 'vue';
import ProjectMonitoring from './components/ProjectMonitoring.vue';

const mountEl = document.getElementById('project-monitoring-root');
if (mountEl) {
    const dataset = mountEl.dataset.projects;
    let projects = [];
    if (dataset) {
        try {
            projects = JSON.parse(dataset);
        } catch (e) {
            // ignore malformed data
        }
    }

    createApp(ProjectMonitoring, { projects }).mount(mountEl);
}
