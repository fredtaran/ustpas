@extends('../base')

@section('title', 'Courses')

@section('map_site')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Courses</h1>
    </div><!-- /.col -->

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admission.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Courses</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <button type="button" class="btn btn-default btn-outline-primary" data-toggle="modal" data-target="#modal-newCourses">
            <i class="fa fa-plus"></i> New course
        </button>
        <table class="table table-bordered table-hover text-center" id="tbl_courses">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Description</th>
                    <th>Chairperson</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="modal-newCourses">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new course</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('admission.save_course') }}" method="POST" id="newCourse_form">
                        <div class="modal-body">
                                @csrf
                                <div class="form-group">
                                    <label for="course_name">Course Name</label>
                                    <input type="text" name="course_name" class="form-control" id="course_name">
                                </div>

                                <div class="form-group">
                                    <label for="course_code">Course Code</label>
                                    <input type="text" name="course_code" class="form-control" id="course_code" placeholder="e.g BSIT">
                                </div>

                                <div class="form-group">
                                    <label for="chairperson">Course Chairperson</label>
                                    <select name="chairperson" id="chairperson" class="form-control">
                                        <option value="">--- Please select the course chairperson ---</option>
                                        @foreach ($chairpersons as $chairperson)
                                        <option value="{{ $chairperson->id }}">{{ sprintf("$chairperson->last_name, $chairperson->first_name $chairperson->suffix") }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</div>
@endsection

@section('page_custom_script')
<script>
  $(function () {
    // Modal form validation
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#newCourse_form').validate({
        rules: {
            course_name: {
                required: true,
            },
        },

        messages: {
            course_name: {
                required: "Please enter a the full course name",
            },
        },

        errorElement: 'span',

        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },

        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    $("#tbl_courses").DataTable({
        ajax: "{{ route('admission.course_list') }}",
        columns: [
            { data: 'course_code' },
            { data: 'course_name' },
            { data: 'chairperson', render: function(data, type, row, meta) {
                return data[0].first_name + " " + (data[0].middle_name == null ? "" : data[0].middle_name[0] + ".") + " " + data[0].last_name + " " + (data[0].suffix == null ? "" : data[0].suffix)
            }},
            { data: 'id', render: function(data, type, row, meta) {
                return '<button type="button" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-warning btn-sm" title="Delete"><i class="fa fa-trash-alt"></i></button>'
            }},
        ],
        responsive: true, 
        lengthChange: false, 
        autoWidth: false,
    });
  });
</script>
@endsection