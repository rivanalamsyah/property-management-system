/**
 * Centralized ES6 JavaScript Architecture - KosManager
 */

// 1. Network Status Monitor
export const NetworkMonitor = {
  init() {
    // Create status banner container dynamically
    const alertDiv = document.createElement('div');
    alertDiv.id = 'network-alert-banner';
    alertDiv.className = 'network-alert';
    alertDiv.innerHTML = `
      <span class="alert-icon flex items-center justify-center bg-indigo-500/10 text-indigo-400 p-1.5 rounded-lg">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0zM12 9v4M12 17h.01"></path>
        </svg>
      </span>
      <div class="alert-content">
        <h4 class="text-xs font-bold text-white leading-none">Connection Offline</h4>
        <p class="text-[10px] text-slate-400 mt-1 leading-none">Running in read-only offline fallback mode.</p>
      </div>
    `;
    document.body.appendChild(alertDiv);

    window.addEventListener('online', () => this.handleStatusChange(true));
    window.addEventListener('offline', () => this.handleStatusChange(false));

    // Initial check
    if (!navigator.onLine) {
      this.handleStatusChange(false);
    }
  },

  handleStatusChange(isOnline) {
    const banner = document.getElementById('network-alert-banner');
    if (!banner) return;

    if (isOnline) {
      banner.classList.remove('show');
      // Toast notification for restoration
      window.dispatchEvent(new CustomEvent('toast', {
        detail: { type: 'success', message: 'Connection restored. Synchronization active.' }
      }));
    } else {
      banner.classList.add('show');
      window.dispatchEvent(new CustomEvent('toast', {
        detail: { type: 'warning', message: 'Connection lost. Working in offline mode.' }
      }));
    }
  }
};

// 2. Service Worker & PWA Installer Manager
export const PWAManager = {
  deferredInstallPrompt: null,

  init() {
    this.registerServiceWorker();
    this.listenInstallPrompt();
  },

  registerServiceWorker() {
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').then((reg) => {
          // Detect service worker updates
          reg.addEventListener('updatefound', () => {
            const newWorker = reg.installing;
            newWorker.addEventListener('statechange', () => {
              if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                // Trigger reload toast notification
                window.dispatchEvent(new CustomEvent('toast', {
                  detail: { 
                    type: 'info', 
                    message: 'New application update available. Click to refresh.',
                    action: () => window.location.reload()
                  }
                }));
              }
            });
          });
        }).catch((err) => {
          console.error('ServiceWorker registration failed: ', err);
        });
      });
    }
  },

  listenInstallPrompt() {
    window.addEventListener('beforeinstallprompt', (e) => {
      // Prevent standard browser banner
      e.preventDefault();
      this.deferredInstallPrompt = e;
      
      // Dispatch custom PWA installable event (UI component can listen and show install button)
      window.dispatchEvent(new CustomEvent('pwa-installable'));
    });
  },

  install() {
    if (this.deferredInstallPrompt) {
      this.deferredInstallPrompt.prompt();
      this.deferredInstallPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the PWA install prompt');
        }
        this.deferredInstallPrompt = null;
      });
    }
  }
};

// Initialize Modules when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  NetworkMonitor.init();
  PWAManager.init();
});
