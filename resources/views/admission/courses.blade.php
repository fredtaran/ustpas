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

        <!-- Add new course modal -->
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
        <!-- /.Add new course modal -->

        <!-- Edit course modal -->
        <div class="modal fade" id="modal-editCourses">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit course</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" id="editCourse_form">
                        <div class="modal-body">
                                @csrf
                                <div class="form-group">
                                    <label for="edit_course_name">Course Name</label>
                                    <input type="text" name="edit_course_name" class="form-control" id="edit_course_name">
                                </div>

                                <div class="form-group">
                                    <label for="edit_course_code">Course Code</label>
                                    <input type="text" name="edit_course_code" class="form-control" id="edit_course_code">
                                </div>

                                <div class="form-group">
                                    <label for="edit_chairperson">Course Chairperson</label>
                                    <select name="edit_chairperson" id="edit_chairperson" class="form-control">
                                        <option value="">--- Please select the course chairperson ---</option>
                                        @foreach ($chairpersons as $chairperson)
                                        <option value="{{ $chairperson->id }}">{{ sprintf("$chairperson->last_name, $chairperson->first_name $chairperson->suffix") }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update changes</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- /.Edit course modal -->
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

    // New course modal form validation
    $('#newCourse_form').validate({
        rules: {
            course_name: {
                required: true,
            },
            
            course_code: {
                required: true,
            },

            chairperson: {
                required: true,
            }
        },

        messages: {
            course_name: {
                required: "Please enter the full course name",
            },

            course_code: {
                required: "Please enter the full course code/abbreviation",
            },

            chairperson: {
                required: "Please select the course chairperson",
            }
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

    // Edit course modal form validation
    $('#editCourse_form').validate({
        rules: {
            edit_course_name: {
                required: true,
            },
            
            edit_course_code: {
                required: true,
            },

            edit_chairperson: {
                required: true,
            }
        },

        messages: {
            edit_course_name: {
                required: "Please enter the full course name",
            },

            edit_course_code: {
                required: "Please enter the full course code/abbreviation",
            },

            edit_chairperson: {
                required: "Please select the course chairperson",
            }
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

    // DataTable setup
    const courseTable = $("#tbl_courses").DataTable({
        ajax: "{{ route('admission.course_list') }}",
        columns: [
            { data: 'course_code', render: function(data, type, row, meta) {
                return '<a href="{{ url('/admission/course/') }}/' + row.id + '">' + data + '</a>';
            }},
            { data: 'course_name' },
            { data: 'chairperson', render: function(data, type, row, meta) {
                return data[0].first_name + " " + (data[0].middle_name == null ? "" : data[0].middle_name[0] + ".") + " " + data[0].last_name + " " + (data[0].suffix == null ? "" : data[0].suffix)
            }},
            { data: 'id', render: function(data, type, row, meta) {
                return '<button type="button" class="btn btn-primary btn-sm editCourseBtn" title="Edit"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-warning btn-sm deleteCourseBtn" title="Delete"><i class="fa fa-trash-alt"></i></button>'
            }},
        ],
        responsive: true, 
        lengthChange: false, 
        autoWidth: false,
    });

    
    
    // Delete button function
    courseTable.on('click', 'td button.deleteCourseBtn', function() {
        var data = courseTable.row($(this).parents('tr')).data();
        Swal.fire({
            title: "Delete Confirmation",
            text: "Are you sure you want to delete " + data.course_name + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "Cancel"
        }).then(function(result) {
            if(result.value) {
                $.ajax({
                    url: "{{ url('/admission/courses') }}/" + data.id,
                    type: "DELETE",
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success Message",
                            text: response.message,
                            icon: "info"
                        });

                        courseTable.ajax.reload();
                    },
                    error: function(xhr, response, error) {
                        console.log(error);
                    }
                });
            }
        });
    })

    // Edit button function
    courseTable.on('click', 'td button.editCourseBtn', function() {
        var data = courseTable.row($(this).parents('tr')).data();

        // Retrieve data
        $.ajax({
            url: "{{ url('/admission/courses') }}/" + data.id,
            type: "GET",
            dataType: 'json',
            success: function(response) {
                // Show modal
                $('#editCourse_form').attr('action', "{{ url('/admission/courses') }}/" + data.id + "/edit");
                $('#modal-editCourses').modal('show');
                $('#edit_course_name').val(response.course.course_name);
                $('#edit_course_code').val(response.course.course_code);
                $('#edit_chairperson option[value="' + response.course.chairperson_id + '"]').prop('selected', true);
            },
            error: function(xhr, response, error) {
                console.log(error);
            }
        });
    });
  });
</script>
@endsection