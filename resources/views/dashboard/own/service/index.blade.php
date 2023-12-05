@extends('dashboard.own.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('own.service-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createServiceModal').modal('hide');
        $('#updateServiceModal').modal('hide');
        $('#deleteServiceModal').modal('hide');
    })
</script>
@endsection