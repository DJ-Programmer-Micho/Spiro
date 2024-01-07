@extends('dashboard.edt.layout.master')
@section('tail','Invoice')
@section('dash_content')
<div>
    @livewire('edt.invoice-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createInvoiceModal').modal('hide');
        $('#editInvoiceModal').modal('hide');
    })
    window.addEventListener('close-modal-direct', event => {
        // Direct Forms
        $('#addClientDirect').modal('hide');
    })

</script>
@endsection
