/**
 * Custom confirm modal – Gracia P-11, P-12, P-16
 * Mengganti browser confirm() bawaan dengan modal bergaya EcoBank.
 */
(function () {
    // Inject HTML modal ke body (sekali saja)
    function injectModal() {
        if (document.getElementById('gracia-overlay')) return;
        const html = `
<div id="gracia-overlay" class="gracia-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="gracia-modal-title">
  <div class="gracia-modal">
    <div class="gracia-modal-icon">
      <span>🗑️</span>
    </div>
    <div class="gracia-modal-body">
      <h3 id="gracia-modal-title">Konfirmasi</h3>
      <p id="gracia-modal-msg"></p>
      <div class="gracia-modal-actions">
        <button type="button" class="gracia-btn-cancel" id="gracia-btn-cancel">Batal</button>
        <button type="button" class="gracia-btn-confirm" id="gracia-btn-confirm">Ya, Lanjutkan</button>
      </div>
    </div>
  </div>
</div>`;
        document.body.insertAdjacentHTML('beforeend', html);
    }

    function showModal(message, onConfirm) {
        const overlay = document.getElementById('gracia-overlay');
        const msgEl   = document.getElementById('gracia-modal-msg');
        const btnOk   = document.getElementById('gracia-btn-confirm');
        const btnNo   = document.getElementById('gracia-btn-cancel');

        msgEl.textContent = message;
        overlay.style.display = 'flex';

        // Clone buttons to remove stale listeners
        const newOk = btnOk.cloneNode(true);
        const newNo = btnNo.cloneNode(true);
        btnOk.parentNode.replaceChild(newOk, btnOk);
        btnNo.parentNode.replaceChild(newNo, btnNo);

        function close() { overlay.style.display = 'none'; }

        newOk.addEventListener('click', function () {
            close();
            onConfirm();
        });
        newNo.addEventListener('click', close);

        // Klik di luar modal → tutup
        overlay.addEventListener('click', function handler(e) {
            if (e.target === overlay) {
                close();
                overlay.removeEventListener('click', handler);
            }
        });

        // ESC → tutup
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') {
                close();
                document.removeEventListener('keydown', handler);
            }
        });
    }

    // Pasang listener ke semua form yang punya data-gracia-confirm
    function bindForms() {
        document.querySelectorAll('form[data-gracia-confirm]').forEach(function (form) {
            // Hindari double-bind
            if (form._graciabound) return;
            form._graciabound = true;

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const msg = form.getAttribute('data-gracia-confirm') || 'Yakin ingin melanjutkan?';
                showModal(msg, function () { form.submit(); });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        injectModal();
        bindForms();
    });
})();
