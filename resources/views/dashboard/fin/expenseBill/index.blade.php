@extends('dashboard.fin.layout.master')
@section('tail','Expense')
@section('dash_content')
<div>
    @livewire('fin.expense-bill-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createBillModal').modal('hide');
        $('#updateBillModal').modal('hide');
    })
</script>
@endsection