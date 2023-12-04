@extends('layouts.layout')
@section('tail','Service')
@section('dash_content')
<div>
    @livewire('dashboard.service-livewire')
</div>
@endsection
@section('dash_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createServiceModal').modal('hide');
        $('#updateServiceModal').modal('hide');
        $('#deleteServiceModal').modal('hide');
    })
</script>
@endsection