@extends('layouts.layout')
@section('tail','Branch')
@section('dash_content')
<div>
    @livewire('dashboard.branch-livewire')
</div>
@endsection
@section('dash_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createBranchModal').modal('hide');
        $('#updateBranchModal').modal('hide');
        $('#deleteBranchModal').modal('hide');
    })
</script>
@endsection