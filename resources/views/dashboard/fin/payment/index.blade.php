@extends('dashboard.fin.layout.master')
@section('tail','Payment')
@section('dash_content')
<div>
    @livewire('fin.payment-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createPaymentModal').modal('hide');
        $('#updatePaymentModal').modal('hide');
    })
</script>
@endsection