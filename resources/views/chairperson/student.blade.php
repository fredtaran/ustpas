@extends('../base')

@section('title', 'Chairperson')

@section('map_site')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Subject/s for accreditation</h1>
    </div><!-- /.col -->

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admission.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">{{ $student->last_name }}, {{ $student->first_name }}</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover text-center" id="tbl_forAccre">
            <thead>
                <tr>
                    <th colspan=3>Subjects to be Accredited</th>
                    <th rowspan=2 class="align-middle">Accredited to (Subject Code & Descriptive Title)</th>
                    <th rowspan=2 class="align-middle">Grade</th>
                    <th rowspan=2 class="align-middle">Actions</th>
                </tr>
                <tr>
                    <th>Subject Code</th>
                    <th>Descriptive Title</th>
                    <th>Units</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('page_custom_script')
<script>
    $(function() {
        var tableForAccre = $('#tbl_forAccre').DataTable({
            ajax: "{{ url('/chairperson/student') }}/" + {{ $student->id }} + "/subjects/",
            columns: [
                { data: 'subject_code_to_be_credited' },
                { data: 'subject_title_to_be_credited' },
                { data: 'subject.unit' },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return data.subject.subject_code + ' - ' + data.subject.subject_description
                    }
                },
                { data: 'grade' },
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<button class="btn btn-sm btn-primary approve"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-danger denied"><i class="fa fa-times"></i></button>`
                    }
                }
            ],
            responsive: true, 
            lengthChange: false, 
            autoWidth: false,
        });

        tableForAccre.on('click', 'button.approve', function() {
            var data = tableForAccre.row($(this).parents('tr')).data();
            $.ajax({
                url: "{{ url('/chairperson/accredit') }}/" + data.id + "/approved",
                type: "PUT",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    tableForAccre.ajax.reload();
                },
                error: function(xhr, errorStatus, error) {
                    console.log(error)
                }
            });
        });

        tableForAccre.on('click', 'button.denied', function() {
            var data = tableForAccre.row($(this).parents('tr')).data();
            $.ajax({
                url: "{{ url('/chairperson/accredit') }}/" + data.id + "/denied",
                type: "PUT",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    tableForAccre.ajax.reload();
                },
                error: function(xhr, errorStatus, error) {
                    console.log(error)
                }
            });
        });
    })
</script>
@endsection