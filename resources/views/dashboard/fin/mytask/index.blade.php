@extends('dashboard.fin.layout.master')
@section('tail','My Tasks')
@section('dash_content')
<div>
    @livewire('fin.my-task-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createMyTaskModal').modal('hide');
        $('#updateMyTaskModal').modal('hide');
    })
</script>
@endsection