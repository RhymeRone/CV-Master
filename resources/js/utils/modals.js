/**
 * Modal elementini temizler ve kapatır
 * @param {string} modalId - Modal seçici (#modalId)
 */
function disposeModal(modalId) {
    try {
        // Backdrop elementlerini temizle
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        
        // Body stillerini temizle
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');

        // İnputları temizle
        document.querySelectorAll('.modal-body input').forEach(input => {
            if(input.type === "radio" || input.type === "checkbox") {
                input.checked = false;
            } else {
                input.value = '';
            }
        });

        // Success ve Error mesajlarını temizle
        document.querySelectorAll('.modal-body input').forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
            // Inputun bulunduğu grubun invalid feedback elementini kaldır
            const invalidFeedback = input.closest('.input-group')?.querySelector('.invalid-feedback');
            if (invalidFeedback) {
                invalidFeedback.remove();
            }
        });
        
        // Modal elementini temizle
        const modalEl = document.querySelector(modalId);
        if (modalEl) {
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
            modalEl.removeAttribute('aria-modal');
        }
    } catch (error) {
        console.error('Modal temizlenirken hata:', error);
    }
}

/**
 * Modal elementini gösterir
 * @param {string} modalId - Modal seçici (#modalId)
 */
function showModal(modalId) {
    try {
        setTimeout(() => {
            const modalEl = document.querySelector(modalId);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }, 50);
    } catch (error) {
        console.error('Modal açılırken hata:', error);
    }
}

function setupModalListeners() {
    document.querySelectorAll('.modal').forEach(modalElement => {
        // Her modalın kapanma olayını dinle
        modalElement.addEventListener('hidden.bs.modal', function() {
            let modalId = '#' + this.id;
            setTimeout(() => disposeModal(modalId), 100);
        });
    });
}


// Global erişim için
window.disposeModal = disposeModal;
window.showModal = showModal;
window.setupModalListeners = setupModalListeners;

export { disposeModal, showModal, setupModalListeners };