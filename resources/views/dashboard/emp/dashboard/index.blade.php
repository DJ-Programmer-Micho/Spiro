@extends('dashboard.emp.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('emp.dashboard-livewire')
</div>
@endsection
@section('dash_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createModal').modal('hide');
        $('#updateModal').modal('hide');
        $('#deleteModal').modal('hide');
    })
</script>
@endsection