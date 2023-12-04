@extends('layouts.layout')
@section('tail','Quotation')
@section('dash_content')
<div>
    @livewire('dashboard.quotation-livewire')
</div>
@endsection
@section('dash_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createQuotationModal').modal('hide');
        $('#updateQuotationModal').modal('hide');
        $('#deleteQuotationModal').modal('hide');
    })
</script>
@endsection