@extends('dashboard.own.layout.master')
@section('tail','Expense')
@section('dash_content')
<div>
    @livewire('own.quotation-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createQuotationModal').modal('hide');
        $('#editQuotationModal').modal('hide');
        $('#deleteQuotationModal').modal('hide');
    })
</script>
@endsection