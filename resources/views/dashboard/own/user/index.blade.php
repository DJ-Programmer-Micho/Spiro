@extends('dashboard.own.layout.master')
@section('tail','Clients')
@section('dash_content')
<div>
    @livewire('own.user-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createUserModal').modal('hide');
        $('#updateUserModal').modal('hide');
        $('#deleteUserModal').modal('hide');
    })
</script>
@endsection