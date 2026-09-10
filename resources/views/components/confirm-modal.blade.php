{{-- Modern Custom Confirmation Modal Dialog --}}
<div id="custom-confirm-modal" class="fixed inset-0 z-[100000] hidden items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="confirm-modal-title">
    <!-- Backdrop with blur -->
    <div id="confirm-modal-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

    <!-- Modal Card -->
    <div id="confirm-modal-card" class="relative bg-white rounded-3xl shadow-2xl shadow-slate-900/20 max-w-md w-full p-6 sm:p-7 border border-slate-100 transform transition-all duration-300 scale-95 opacity-0 text-center">
        <!-- Close Button -->
        <button type="button" id="confirm-modal-close-btn" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-colors" title="Batal" aria-label="Tutup dialog">
            <i class="fas fa-times text-sm"></i>
        </button>

        <!-- Icon Badge -->
        <div id="confirm-modal-icon-badge" class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-600 flex items-center justify-center mx-auto mb-4 shadow-xs">
            <i id="confirm-modal-icon" class="fas fa-trash-alt text-2xl"></i>
        </div>

        <!-- Title -->
        <h3 id="confirm-modal-title" class="text-lg sm:text-xl font-bold text-slate-900 leading-snug">
            Konfirmasi Tindakan
        </h3>

        <!-- Message -->
        <p id="confirm-modal-message" class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
            Apakah Anda yakin ingin melanjutkan tindakan ini?
        </p>

        <!-- Action Buttons -->
        <div class="mt-6 flex flex-col-reverse sm:flex-row items-center gap-3">
            <button type="button" id="confirm-modal-cancel-btn" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-slate-300 cursor-pointer">
                Batal
            </button>
            <button type="button" id="confirm-modal-ok-btn" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs sm:text-sm transition-all shadow-md shadow-rose-600/25 focus:outline-none focus:ring-2 focus:ring-rose-400 cursor-pointer flex items-center justify-center gap-2">
                <span id="confirm-modal-ok-text">Ya, Lanjutkan</span>
            </button>
        </div>
    </div>
</div>

@once
<script>
    (function() {
        var modal = null;
        var backdrop = null;
        var card = null;
        var titleEl = null;
        var messageEl = null;
        var iconBadgeEl = null;
        var iconEl = null;
        var okBtn = null;
        var okTextEl = null;
        var cancelBtn = null;
        var closeBtn = null;
        var currentConfirmCallback = null;

        function getElements() {
            modal = document.getElementById('custom-confirm-modal');
            backdrop = document.getElementById('confirm-modal-backdrop');
            card = document.getElementById('confirm-modal-card');
            titleEl = document.getElementById('confirm-modal-title');
            messageEl = document.getElementById('confirm-modal-message');
            iconBadgeEl = document.getElementById('confirm-modal-icon-badge');
            iconEl = document.getElementById('confirm-modal-icon');
            okBtn = document.getElementById('confirm-modal-ok-btn');
            okTextEl = document.getElementById('confirm-modal-ok-text');
            cancelBtn = document.getElementById('confirm-modal-cancel-btn');
            closeBtn = document.getElementById('confirm-modal-close-btn');
        }

        window.showConfirmDialog = function(options) {
            getElements();
            if (!modal) return;

            options = options || {};
            var title = options.title || 'Konfirmasi Tindakan';
            var message = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            var confirmText = options.confirmText || 'Ya, Lanjutkan';
            var cancelText = options.cancelText || 'Batal';
            var type = options.type || 'danger'; // 'danger', 'warning', 'info'
            currentConfirmCallback = options.onConfirm || null;

            titleEl.textContent = title;
            messageEl.textContent = message;
            okTextEl.textContent = confirmText;
            cancelBtn.textContent = cancelText;

            // Type styling
            if (type === 'danger') {
                iconBadgeEl.className = 'w-16 h-16 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-600 flex items-center justify-center mx-auto mb-4 shadow-xs';
                iconEl.className = 'fas fa-trash-alt text-2xl';
                okBtn.className = 'w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs sm:text-sm transition-all shadow-md shadow-rose-600/25 focus:outline-none focus:ring-2 focus:ring-rose-400 cursor-pointer flex items-center justify-center gap-2';
            } else if (type === 'warning') {
                iconBadgeEl.className = 'w-16 h-16 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-600 flex items-center justify-center mx-auto mb-4 shadow-xs';
                iconEl.className = 'fas fa-exclamation-triangle text-2xl';
                okBtn.className = 'w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs sm:text-sm transition-all shadow-md shadow-amber-600/25 focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer flex items-center justify-center gap-2';
            } else {
                iconBadgeEl.className = 'w-16 h-16 rounded-2xl bg-blue-50 border border-blue-200/80 text-blue-600 flex items-center justify-center mx-auto mb-4 shadow-xs';
                iconEl.className = 'fas fa-info-circle text-2xl';
                okBtn.className = 'w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm transition-all shadow-md shadow-blue-600/25 focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-pointer flex items-center justify-center gap-2';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(function() {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            });
        };

        window.hideConfirmDialog = function() {
            getElements();
            if (!modal) return;

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(function() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                currentConfirmCallback = null;
            }, 250);
        };

        document.addEventListener('DOMContentLoaded', function() {
            getElements();

            if (cancelBtn) cancelBtn.addEventListener('click', window.hideConfirmDialog);
            if (closeBtn) closeBtn.addEventListener('click', window.hideConfirmDialog);
            if (backdrop) backdrop.addEventListener('click', window.hideConfirmDialog);

            if (okBtn) {
                okBtn.addEventListener('click', function() {
                    var callback = currentConfirmCallback;
                    window.hideConfirmDialog();
                    if (typeof callback === 'function') {
                        callback();
                    }
                });
            }

            // ESC key to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                    window.hideConfirmDialog();
                }
            });

            // Global delegation for elements with data-confirm
            document.addEventListener('click', function(e) {
                var target = e.target.closest('[data-confirm]');
                if (!target) return;

                e.preventDefault();
                e.stopPropagation();

                var message = target.getAttribute('data-confirm');
                var title = target.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
                var confirmText = target.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';
                var cancelText = target.getAttribute('data-cancel-btn') || 'Batal';
                var type = target.getAttribute('data-confirm-type') || 'danger';

                window.showConfirmDialog({
                    title: title,
                    message: message,
                    confirmText: confirmText,
                    cancelText: cancelText,
                    type: type,
                    onConfirm: function() {
                        if (target.tagName === 'BUTTON' || target.tagName === 'INPUT') {
                            var form = target.closest('form');
                            if (form) {
                                form.submit();
                            }
                        } else if (target.tagName === 'A' && target.href) {
                            window.location.href = target.href;
                        }
                    }
                });
            });

            // Global delegation for forms with data-confirm
            document.addEventListener('submit', function(e) {
                var form = e.target;
                if (!form || !form.hasAttribute('data-confirm')) return;

                if (form.dataset.confirmed === 'true') {
                    delete form.dataset.confirmed;
                    return; // Allow submission
                }

                e.preventDefault();
                e.stopPropagation();

                var message = form.getAttribute('data-confirm');
                var title = form.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
                var confirmText = form.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';
                var cancelText = form.getAttribute('data-cancel-btn') || 'Batal';
                var type = form.getAttribute('data-confirm-type') || 'danger';

                window.showConfirmDialog({
                    title: title,
                    message: message,
                    confirmText: confirmText,
                    cancelText: cancelText,
                    type: type,
                    onConfirm: function() {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            });
        });
    })();
</script>
@endonce
