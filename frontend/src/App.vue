<template>
  <div class="app">
    <header class="header">
      <h1>🚀 Dokploy Demo</h1>
      <p class="subtitle">Vue.js + Yii2 + PostgreSQL</p>
    </header>

    <main class="main">
      <div class="card">
        <h2>API Status</h2>
        <div class="status" :class="{ loading, error: apiError, success: !loading && !apiError }">
          <template v-if="loading">
            <span class="spinner"></span>
            Loading...
          </template>
          <template v-else-if="apiError">
            ❌ {{ apiError }}
          </template>
          <template v-else>
            ✅ Connected
          </template>
        </div>
      </div>

      <div class="card" v-if="apiData">
        <h2>API Response</h2>
        <pre class="code">{{ JSON.stringify(apiData, null, 2) }}</pre>
      </div>

      <div class="card" v-if="healthData">
        <h2>Health Check</h2>
        <pre class="code">{{ JSON.stringify(healthData, null, 2) }}</pre>
      </div>

      <div class="actions">
        <button @click="fetchApi" :disabled="loading">Refresh API</button>
        <button @click="fetchHealth" :disabled="loading">Check Health</button>
      </div>
    </main>

    <footer class="footer">
      <p>Ready for Dokploy deployment</p>
    </footer>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'App',
  setup() {
    const loading = ref(false)
    const apiData = ref(null)
    const healthData = ref(null)
    const apiError = ref(null)

    const fetchApi = async () => {
      loading.value = true
      apiError.value = null
      try {
        const response = await fetch('/api')
        if (!response.ok) throw new Error(`HTTP ${response.status}`)
        apiData.value = await response.json()
      } catch (err) {
        apiError.value = err.message
      } finally {
        loading.value = false
      }
    }

    const fetchHealth = async () => {
      loading.value = true
      apiError.value = null
      try {
        const response = await fetch('/api/health')
        if (!response.ok) throw new Error(`HTTP ${response.status}`)
        healthData.value = await response.json()
      } catch (err) {
        apiError.value = err.message
      } finally {
        loading.value = false
      }
    }

    onMounted(() => {
      fetchApi()
    })

    return {
      loading,
      apiData,
      healthData,
      apiError,
      fetchApi,
      fetchHealth,
    }
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
  background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
  min-height: 100vh;
  color: #e4e4e7;
}

.app {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.header {
  text-align: center;
  margin-bottom: 2rem;
}

.header h1 {
  font-size: 2.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.subtitle {
  color: #a1a1aa;
  margin-top: 0.5rem;
}

.main {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 1.5rem;
  backdrop-filter: blur(10px);
}

.card h2 {
  font-size: 1.1rem;
  color: #a1a1aa;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.status {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem;
  border-radius: 8px;
  font-weight: 500;
}

.status.loading {
  background: rgba(234, 179, 8, 0.1);
  color: #fbbf24;
}

.status.error {
  background: rgba(239, 68, 68, 0.1);
  color: #f87171;
}

.status.success {
  background: rgba(34, 197, 94, 0.1);
  color: #4ade80;
}

.spinner {
  width: 16px;
  height: 16px;
  border: 2px solid currentColor;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.code {
  background: rgba(0, 0, 0, 0.3);
  padding: 1rem;
  border-radius: 8px;
  overflow-x: auto;
  font-family: 'Fira Code', 'Monaco', monospace;
  font-size: 0.875rem;
  line-height: 1.5;
  color: #a5f3fc;
}

.actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
}

button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.footer {
  text-align: center;
  margin-top: 2rem;
  color: #71717a;
}
</style>
