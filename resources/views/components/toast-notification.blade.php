{{-- Modern Floating Toast Notification System --}}
<div id="toast-container" class="fixed top-5 right-5 sm:top-6 sm:right-6 z-[99999] flex flex-col gap-3 pointer-events-none max-w-[calc(100vw-2.5rem)] sm:max-w-md w-full" aria-live="polite">
    @php
        $flashes = [];
        if (session('success')) {
            $flashes[] = ['type' => 'success', 'title' => 'Berhasil', 'message' => session('success')];
        }
        if (session('error')) {
            $flashes[] = ['type' => 'error', 'title' => 'Perhatian', 'message' => session('error')];
        }
        if (session('warning')) {
            $flashes[] = ['type' => 'warning', 'title' => 'Peringatan', 'message' => session('warning')];
        }
        if (session('info')) {
            $flashes[] = ['type' => 'info', 'title' => 'Informasi', 'message' => session('info')];
        }
        if (session('status')) {
            $flashes[] = ['type' => 'info', 'title' => 'Status', 'message' => session('status')];
        }
        if (isset($errors) && $errors->any()) {
            $flashes[] = ['type' => 'error', 'title' => 'Terdapat Kesalahan', 'message' => $errors->first()];
        }
    @endphp

    @foreach($flashes as $flash)
        <div class="toast-item pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200/90 overflow-hidden transition-all duration-300 transform translate-y-0 opacity-100"
             data-type="{{ $flash['type'] }}"
             data-auto-dismiss="4500"
             role="alert">
            <div class="p-4 flex items-start gap-3.5">
                @if($flash['type'] === 'success')
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                @elseif($flash['type'] === 'error')
                    <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-200/80 text-rose-600 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                    </div>
                @elseif($flash['type'] === 'warning')
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200/80 text-amber-600 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                @else
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200/80 text-blue-600 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                @endif

                <div class="flex-1 min-w-0 pt-0.5">
                    <div class="flex items-center justify-between gap-2 mb-0.5">
                        <span class="text-[11px] font-bold tracking-wider uppercase {{ $flash['type'] === 'success' ? 'text-emerald-700' : ($flash['type'] === 'error' ? 'text-rose-700' : ($flash['type'] === 'warning' ? 'text-amber-700' : 'text-blue-700')) }}">
                            {{ $flash['title'] }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-slate-700 leading-snug break-words">
                        {{ $flash['message'] }}
                    </p>
                </div>

                <button type="button" class="toast-close-btn text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition-colors shrink-0 -mr-1 -mt-1" title="Tutup" aria-label="Tutup notifikasi">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            {{-- Progress countdown bar --}}
            <div class="toast-progress h-1 w-full bg-slate-100 overflow-hidden">
                <div class="toast-progress-bar h-full transition-all duration-[4500ms] ease-linear w-full {{ $flash['type'] === 'success' ? 'bg-emerald-500' : ($flash['type'] === 'error' ? 'bg-rose-500' : ($flash['type'] === 'warning' ? 'bg-amber-500' : 'bg-blue-500')) }}"></div>
            </div>
        </div>
    @endforeach
</div>

@once
<script>
    (function() {
        // Dismiss a toast element with smooth exit animation
        window.dismissToast = function(toastEl) {
            if (!toastEl || toastEl.classList.contains('is-dismissing')) return;
            toastEl.classList.add('is-dismissing');
            toastEl.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateX(30px) scale(0.95)';
            setTimeout(function() {
                if (toastEl.parentNode) {
                    toastEl.parentNode.removeChild(toastEl);
                }
            }, 300);
        };

        // Initialize timers for a toast element
        function initToast(toastEl) {
            var closeBtn = toastEl.querySelector('.toast-close-btn');
            var progressBar = toastEl.querySelector('.toast-progress-bar');
            var duration = parseInt(toastEl.getAttribute('data-auto-dismiss') || '4500', 10);

            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    window.dismissToast(toastEl);
                });
            }

            // Animate progress bar from 100% to 0%
            if (progressBar) {
                // Trigger reflow to start transition
                requestAnimationFrame(function() {
                    progressBar.style.transition = 'width ' + duration + 'ms linear';
                    progressBar.style.width = '0%';
                });
            }

            var timer = setTimeout(function() {
                window.dismissToast(toastEl);
            }, duration);

            // Pause on hover
            toastEl.addEventListener('mouseenter', function() {
                clearTimeout(timer);
                if (progressBar) {
                    var computedWidth = window.getComputedStyle(progressBar).width;
                    progressBar.style.transition = 'none';
                    progressBar.style.width = computedWidth;
                }
            });

            toastEl.addEventListener('mouseleave', function() {
                timer = setTimeout(function() {
                    window.dismissToast(toastEl);
                }, 1500);
                if (progressBar) {
                    progressBar.style.transition = 'width 1500ms linear';
                    progressBar.style.width = '0%';
                }
            });
        }

        // Global function to trigger toast dynamically via JavaScript
        window.showToast = function(message, type, title, duration) {
            type = type || 'success';
            duration = duration || 4500;
            if (!title) {
                if (type === 'success') title = 'Berhasil';
                else if (type === 'error') title = 'Perhatian';
                else if (type === 'warning') title = 'Peringatan';
                else title = 'Informasi';
            }

            var container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'fixed top-5 right-5 sm:top-6 sm:right-6 z-[99999] flex flex-col gap-3 pointer-events-none max-w-[calc(100vw-2.5rem)] sm:max-w-md w-full';
                document.body.appendChild(container);
            }

            var colorMap = {
                success: { badge: 'bg-emerald-50 border-emerald-200/80 text-emerald-600', icon: 'fa-check-circle', titleColor: 'text-emerald-700', bar: 'bg-emerald-500' },
                error:   { badge: 'bg-rose-50 border-rose-200/80 text-rose-600', icon: 'fa-exclamation-circle', titleColor: 'text-rose-700', bar: 'bg-rose-500' },
                warning: { badge: 'bg-amber-50 border-amber-200/80 text-amber-600', icon: 'fa-exclamation-triangle', titleColor: 'text-amber-700', bar: 'bg-amber-500' },
                info:    { badge: 'bg-blue-50 border-blue-200/80 text-blue-600', icon: 'fa-info-circle', titleColor: 'text-blue-700', bar: 'bg-blue-500' }
            };
            var c = colorMap[type] || colorMap.info;

            var toast = document.createElement('div');
            toast.className = 'toast-item pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200/90 overflow-hidden transition-all duration-300 transform translate-x-8 opacity-0';
            toast.setAttribute('data-type', type);
            toast.setAttribute('data-auto-dismiss', duration);
            toast.setAttribute('role', 'alert');

            toast.innerHTML = 
                '<div class="p-4 flex items-start gap-3.5">' +
                    '<div class="w-10 h-10 rounded-xl ' + c.badge + ' border flex items-center justify-center shrink-0 shadow-xs">' +
                        '<i class="fas ' + c.icon + ' text-lg"></i>' +
                    '</div>' +
                    '<div class="flex-1 min-w-0 pt-0.5">' +
                        '<div class="flex items-center justify-between gap-2 mb-0.5">' +
                            '<span class="text-[11px] font-bold tracking-wider uppercase ' + c.titleColor + '">' + title + '</span>' +
                        '</div>' +
                        '<p class="text-xs sm:text-sm font-medium text-slate-700 leading-snug break-words">' + message + '</p>' +
                    '</div>' +
                    '<button type="button" class="toast-close-btn text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition-colors shrink-0 -mr-1 -mt-1" title="Tutup" aria-label="Tutup notifikasi">' +
                        '<i class="fas fa-times text-xs"></i>' +
                    '</button>' +
                '</div>' +
                '<div class="toast-progress h-1 w-full bg-slate-100 overflow-hidden">' +
                    '<div class="toast-progress-bar h-full transition-all ease-linear w-full ' + c.bar + '"></div>' +
                '</div>';

            container.appendChild(toast);

            // Animate entry
            requestAnimationFrame(function() {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            });

            initToast(toast);
        };

        // Initialize server-rendered toasts on DOM load
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast-item');
            toasts.forEach(function(toast) {
                initToast(toast);
            });
        });
    })();
</script>
@endonce
