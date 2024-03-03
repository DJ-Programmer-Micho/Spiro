@extends('dashboard.fin.layout.master')
@section('tail','Attendance')
@section('dash_content')
<div>
    @livewire('fin.attendance-livewire')
</div>
@endsection
@section('form_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createAttendModal').modal('hide');
        $('#editAttendModal').modal('hide');
        $('#deleteAttendModal').modal('hide');

    })
    // window.addEventListener('close-modal-direct', event => {
    //     // Direct Forms
    //     $('#addClientDirect').modal('hide');
    // })

</script>
@endsection
