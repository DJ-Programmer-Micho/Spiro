@extends('layouts.layout')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('dashboard.client-livewire')
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