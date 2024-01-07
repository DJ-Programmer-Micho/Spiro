@extends('dashboard.edt.layout.master')
@section('tail','Cash Receipt')
@section('dash_content')
<div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @livewire('edt.cash-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createCashModal').modal('hide');
        $('#updateCashModal').modal('hide');
    })
</script>
@endsection
