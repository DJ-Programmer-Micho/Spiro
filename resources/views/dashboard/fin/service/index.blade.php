@extends('dashboard.fin.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('fin.service-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createServiceModal').modal('hide');
        $('#updateServiceModal').modal('hide');
    })
</script>
@endsection