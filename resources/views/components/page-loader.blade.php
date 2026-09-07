<!-- Global Page Loading Screen -->
<div id="global-page-loader" class="fixed inset-0 z-[99999] flex items-center justify-center bg-white/90 backdrop-blur-sm transition-opacity duration-300">
    <div class="relative flex items-center justify-center">
        <!-- Spinner Ring -->
        <div class="w-14 h-14 rounded-full border-2 border-blue-600/20 border-t-blue-600 global-loader-spin"></div>
        <!-- Book Icon -->
        <div class="absolute inset-0 flex items-center justify-center text-blue-600">
            <svg class="w-6 h-6 global-loader-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
    </div>
</div>

<style>
    @keyframes globalLoaderSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes globalLoaderPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.45; transform: scale(0.92); }
    }
    .global-loader-spin {
        animation: globalLoaderSpin 0.9s linear infinite;
    }
    .global-loader-pulse {
        animation: globalLoaderPulse 1.6s ease-in-out infinite;
    }
</style>

<script>
    (function() {
        const loader = document.getElementById('global-page-loader');
        if (!loader) return;

        function hideGlobalLoader() {
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                if (loader) loader.style.display = 'none';
            }, 320);
        }

        function showGlobalLoader() {
            loader.style.display = 'flex';
            loader.classList.remove('opacity-0', 'pointer-events-none');
        }

        // Hide when page is ready
        if (document.readyState === 'complete') {
            setTimeout(hideGlobalLoader, 150);
        } else {
            window.addEventListener('load', function() {
                setTimeout(hideGlobalLoader, 150);
            });
            // Safety timeout so loader is never permanently stuck
            setTimeout(hideGlobalLoader, 2500);
        }

        // Handle browser back/forward cache (BFCache)
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                hideGlobalLoader();
            }
        });

        // Show loader when navigating to internal links
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            
            const href = link.getAttribute('href');
            if (!href || 
                href.startsWith('#') || 
                href.startsWith('javascript:') || 
                href.startsWith('mailto:') || 
                href.startsWith('tel:') || 
                link.target === '_blank' || 
                link.hasAttribute('download')) {
                return;
            }

            // Only trigger for same-origin links
            try {
                const targetUrl = new URL(link.href, window.location.origin);
                if (targetUrl.origin === window.location.origin && (targetUrl.pathname !== window.location.pathname || targetUrl.search !== window.location.search)) {
                    showGlobalLoader();
                }
            } catch(err) {}
        });

        // Show loader on form submission
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.target === '_blank') return;
            showGlobalLoader();
        });
    })();
</script>
