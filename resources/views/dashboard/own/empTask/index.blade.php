@extends('dashboard.own.layout.master')
@section('tail','Employee Tasks')
@section('dash_content')
<div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @livewire('own.emp-task-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#newEmpTaskModal').modal('hide');
        $('#createEmpTaskModal').modal('hide');
        $('#updateEmpTaskModal').modal('hide');
        $('#deleteEmpTaskModal').modal('hide');

    })
</script>
@endsection
