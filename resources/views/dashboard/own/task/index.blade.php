@extends('dashboard.own.layout.master')
@section('tail','Option Tsak')
@section('dash_content')
<div>
    @livewire('own.task-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createTaskModal').modal('hide');
        $('#updateTaskModal').modal('hide');
        $('#deleteTaskModal').modal('hide');
    })
</script>
@endsection