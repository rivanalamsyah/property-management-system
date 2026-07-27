/**
 * Centralized ES6 JavaScript Architecture - KosManager
 */



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
  PWAManager.init();
});
