<template>
  <div class="pm-card">
    <div class="pm-header">
      <div class="pm-title">Monitoring Project</div>
      <div class="pm-actions">
        <input
          v-model="searchQuery"
          type="text"
          class="pm-search"
          placeholder="Cari proyek..."
        />
        <select v-model="statusFilter" class="pm-filter">
          <option value="">Semua Status</option>
          <option value="on_track">On Track</option>
          <option value="at_risk">At Risk</option>
          <option value="delayed">Delayed</option>
          <option value="completed">Completed</option>
        </select>
      </div>
    </div>

    <div class="pm-stats">
      <div class="pm-stat">
        <div class="pm-stat-label">Total</div>
        <div class="pm-stat-value">{{ filteredProjects.length }}</div>
      </div>
      <div class="pm-stat">
        <div class="pm-stat-label">On Track</div>
        <div class="pm-stat-value pm-green">{{ countByStatus('on_track') }}</div>
      </div>
      <div class="pm-stat">
        <div class="pm-stat-label">At Risk</div>
        <div class="pm-stat-value pm-amber">{{ countByStatus('at_risk') }}</div>
      </div>
      <div class="pm-stat">
        <div class="pm-stat-label">Delayed</div>
        <div class="pm-stat-value pm-red">{{ countByStatus('delayed') }}</div>
      </div>
      <div class="pm-stat">
        <div class="pm-stat-label">Completed</div>
        <div class="pm-stat-value pm-blue">{{ countByStatus('completed') }}</div>
      </div>
    </div>

    <div class="pm-list">
      <div v-for="project in filteredProjects" :key="project.id" class="pm-item">
        <div class="pm-item-left">
          <div class="pm-item-title">{{ project.name }}</div>
          <div class="pm-item-subtitle">
            PIC: {{ project.owner }} · Deadline: {{ project.deadline }}
          </div>
        </div>
        <div class="pm-item-right">
          <div class="pm-progress">
            <div class="pm-progress-bar" :style="{ width: project.progress + '%' }"></div>
          </div>
          <span class="pm-badge" :class="'pm-' + project.status">
            {{ statusLabel(project.status) }}
          </span>
        </div>
      </div>

      <div v-if="filteredProjects.length === 0" class="pm-empty">
        Tidak ada proyek yang cocok.
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  projects: {
    type: Array,
    default: () => [
      {
        id: 1,
        name: 'Website Revamp',
        owner: 'Ayu',
        deadline: '2025-11-30',
        progress: 72,
        status: 'on_track',
      },
      {
        id: 2,
        name: 'Mobile App V2',
        owner: 'Budi',
        deadline: '2025-12-15',
        progress: 45,
        status: 'at_risk',
      },
      {
        id: 3,
        name: 'Data Warehouse',
        owner: 'Cici',
        deadline: '2026-01-10',
        progress: 25,
        status: 'delayed',
      },
      {
        id: 4,
        name: 'SLA Automation',
        owner: 'Dion',
        deadline: '2025-10-31',
        progress: 100,
        status: 'completed',
      },
    ],
  },
})

const searchQuery = ref('')
const statusFilter = ref('')

const filteredProjects = computed(() => {
  let items = props.projects
  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    items = items.filter((p) =>
      `${p.name} ${p.owner}`.toLowerCase().includes(q)
    )
  }
  if (statusFilter.value) {
    items = items.filter((p) => p.status === statusFilter.value)
  }
  return items
})

function countByStatus(status) {
  return props.projects.filter((p) => p.status === status).length
}

function statusLabel(status) {
  return (
    {
      on_track: 'On Track',
      at_risk: 'At Risk',
      delayed: 'Delayed',
      completed: 'Completed',
    }[status] || status
  )
}
</script>

<style scoped>
:root {
  --pm-blue-50: #ebf5ff;
  --pm-blue-100: #dbeafe;
  --pm-blue-200: #bfdbfe;
  --pm-blue-400: #60a5fa;
  --pm-blue-500: #3b82f6;
  --pm-blue-600: #2563eb;
  --pm-blue-700: #1d4ed8;
  --pm-navy-800: #0b1e3a;
  --pm-slate-600: #475569;
  --pm-slate-800: #1f2937;
  --pm-green: #22c55e;
  --pm-amber: #f59e0b;
  --pm-red: #ef4444;
}

.pm-card {
  background: linear-gradient(180deg, var(--pm-blue-50), #ffffff);
  border: 1px solid var(--pm-blue-100);
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(37, 99, 235, 0.12);
  overflow: hidden;
}

.pm-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 20px;
  background: linear-gradient(90deg, var(--pm-blue-600), var(--pm-blue-500));
  color: white;
}

.pm-title {
  font-weight: 700;
  letter-spacing: 0.3px;
}

.pm-actions { display: flex; gap: 12px; }

.pm-search,
.pm-filter {
  background: rgba(255, 255, 255, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.25);
  color: white;
  padding: 8px 10px;
  border-radius: 10px;
  outline: none;
}

.pm-search::placeholder { color: rgba(255,255,255,0.85); }

.pm-stats {
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: 12px;
  padding: 16px 20px;
}

.pm-stat {
  background: linear-gradient(180deg, white, var(--pm-blue-50));
  border: 1px solid var(--pm-blue-100);
  border-radius: 12px;
  padding: 12px;
  text-align: center;
}

.pm-stat-label { color: var(--pm-slate-600); font-size: 12px; }
.pm-stat-value { font-size: 18px; font-weight: 700; }
.pm-green { color: var(--pm-green); }
.pm-amber { color: var(--pm-amber); }
.pm-red { color: var(--pm-red); }
.pm-blue { color: var(--pm-blue-600); }

.pm-list { padding: 8px 20px 20px; display: grid; gap: 10px; }

.pm-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 14px 14px 14px 16px;
  background: white;
  border: 1px solid var(--pm-blue-100);
  border-radius: 14px;
}

.pm-item-title { font-weight: 600; color: var(--pm-slate-800); }
.pm-item-subtitle { color: var(--pm-slate-600); font-size: 12px; margin-top: 2px; }

.pm-item-right { display: flex; align-items: center; gap: 12px; min-width: 240px; }

.pm-progress {
  position: relative;
  background: var(--pm-blue-100);
  border-radius: 999px;
  height: 8px;
  width: 160px;
  overflow: hidden;
}

.pm-progress-bar {
  position: absolute;
  inset: 0 auto 0 0;
  background: linear-gradient(90deg, var(--pm-blue-500), var(--pm-blue-600));
  width: 0%;
  transition: width 0.4s ease;
}

.pm-badge {
  font-size: 12px;
  font-weight: 700;
  padding: 6px 10px;
  border-radius: 999px;
  text-transform: uppercase;
}

.pm-badge.pm-on_track { background: rgba(34, 197, 94, 0.12); color: var(--pm-green); border: 1px solid rgba(34, 197, 94, 0.25); }
.pm-badge.pm-at_risk { background: rgba(245, 158, 11, 0.12); color: var(--pm-amber); border: 1px solid rgba(245, 158, 11, 0.25); }
.pm-badge.pm-delayed { background: rgba(239, 68, 68, 0.12); color: var(--pm-red); border: 1px solid rgba(239, 68, 68, 0.25); }
.pm-badge.pm-completed { background: rgba(59, 130, 246, 0.12); color: var(--pm-blue-600); border: 1px solid rgba(59, 130, 246, 0.25); }

@media (max-width: 768px) {
  .pm-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .pm-item { flex-direction: column; align-items: flex-start; }
  .pm-item-right { width: 100%; min-width: 0; }
  .pm-progress { width: 100%; }
}
</style>
