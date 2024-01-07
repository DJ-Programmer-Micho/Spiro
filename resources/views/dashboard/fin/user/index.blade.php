@extends('dashboard.fin.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('fin.user-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createUserModal').modal('hide');
        $('#updateUserModal').modal('hide');
    })
</script>
@endsection