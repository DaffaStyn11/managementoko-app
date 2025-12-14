{{-- Modal Component --}}
<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all">
        
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
            <button type="button" onclick="closeModal('{{ $id }}')" 
                class="text-gray-400 hover:text-gray-600 transition-colors">
                <i data-feather="x" class="w-6 h-6"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-6">
            {{ $slot }}
        </div>

    </div>
</div>

<script>
    // Open Modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        feather.replace();
    }

    // Close Modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form if exists
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
            // Clear validation errors
            modal.querySelectorAll('.text-red-600').forEach(el => el.remove());
            modal.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
        }
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    closeModal(modal.id);
                }
            });
        }
    });

    // Close on click outside
    document.addEventListener('click', function(e) {
        if (e.target.id && e.target.id.endsWith('Modal')) {
            closeModal(e.target.id);
        }
    });
</script>
