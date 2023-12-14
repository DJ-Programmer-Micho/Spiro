@extends('dashboard.own.layout.master')
@section('tail','Payment')
@section('dash_content')
<div>
    @livewire('own.payment-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createPaymentModal').modal('hide');
        $('#updatePaymentModal').modal('hide');
        $('#deletePaymentModal').modal('hide');
    })
</script>
@endsection