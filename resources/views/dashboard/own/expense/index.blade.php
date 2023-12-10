@extends('dashboard.own.layout.master')
@section('tail','Expense')
@section('dash_content')
<div>
    @livewire('own.expense-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#selectExpenseModal').modal('hide');
        $('#createExpenseBillModal').modal('hide');

        $('#createExpenseModal').modal('hide');
        $('#updateExpenseModal').modal('hide');
        $('#deleteExpenseModal').modal('hide');
    })
</script>
@endsection