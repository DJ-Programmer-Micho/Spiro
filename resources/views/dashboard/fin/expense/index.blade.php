@extends('dashboard.fin.layout.master')
@section('tail','Expense')
@section('dash_content')
<div>
    @livewire('fin.expense-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#selectExpenseModal').modal('hide');
        $('#createExpenseBillModal').modal('hide');
        $('#createEmployeeModal').modal('hide');
        $('#createExpenseOtherModal').modal('hide');
        $('#editExpenseModal').modal('hide');
    })
</script>
@endsection