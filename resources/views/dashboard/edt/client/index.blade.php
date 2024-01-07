@extends('dashboard.edt.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('edt.client-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createClientModal').modal('hide');
        $('#updateClientModal').modal('hide');
    })
</script>
@endsection