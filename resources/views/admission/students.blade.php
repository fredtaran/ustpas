@extends('../base')

@section('title', 'Students')

@section('map_site')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Students</h1>
    </div><!-- /.col -->

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admission.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Students</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('admission.add_student_view') }}" class="btn btn-default btn-outline-primary">
            <i class="fa fa-plus"></i> Register a student
        </a>

        <table class="table table-bordered table-hover text-center" id="tbl_students">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('page_custom_script')
<script>
    $(function() {
        const tableStudents = $('#tbl_students').DataTable({
            ajax: "{{ route('admission.get_student') }}",
            columns: [
                { 
                    data: 'student_id',
                    render: function(data, type, row, meta) {
                        return '<a href="#">' + data + '</a>'
                    }
                },
                { 
                    data: null, 
                    render: function(data, type, row, meta) {
                        return data.first_name + " " + (data.middle_name == null ? "" : data.middle_name[0] + ".") + " " + data.last_name + " " + (data.suffix == null ? "" : data.suffix)
                    }
                },
                { 
                    data: 'course', 
                    render: function(data, type, row, meta) {
                        return data[0].course_name
                    }
                },
                { data: 'year_level' },
                { 
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return '<a href="#" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a> <button type="button" class="btn btn-warning btn-sm deleteCourseBtn" title="Delete"><i class="fa fa-trash-alt"></i></button>'
                    }
                }
            ],
            responsive: true, 
            lengthChange: false, 
            autoWidth: false,
        });
    })
</script>
@endsection