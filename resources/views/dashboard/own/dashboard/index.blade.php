@extends('dashboard.own.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('own.dashboard-livewire')
</div>
@endsection
@section('dash_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createClientModal').modal('hide');
        $('#updateClientModal').modal('hide');
        $('#deleteClientModal').modal('hide');
    })
</script>
@endsection