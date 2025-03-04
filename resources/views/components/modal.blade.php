@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'modal-sm',
    'md' => 'modal-md',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    '2xl' => '', // Bootstrap doesn't have a 2xl class, leaving it empty
][$maxWidth];
@endphp

<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-labelledby="{{ $name }}Label" aria-hidden="true" style="display: {{ $show ? 'block' : 'none' }};">
    <div class="modal-dialog {{ $maxWidth }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $name }}Label">{{ $name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('{{ $name }}');
        const modal = new bootstrap.Modal(modalElement);

        @if($show)
            modal.show();
        @endif

        window.addEventListener('open-modal', function (event) {
            if (event.detail === '{{ $name }}') {
                modal.show();
            }
        });

        window.addEventListener('close-modal', function (event) {
            if (event.detail === '{{ $name }}') {
                modal.hide();
            }
        });
    });
</script>

