@extends('../base')

@section('title', 'Chairperson')

@section('map_site')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
    </div><!-- /.col -->

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h2>List of Users</h2>

        <button type="button" class="btn btn-default btn-outline-primary" data-toggle="modal" data-target="#modal-newUser">
            <i class="fa fa-plus"></i> Add User
        </button>

        <table class="table table-bordered table-hover text-center" id="tbl_users">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Add new course modal -->
    <div class="modal fade" id="modal-newUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new course</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('superadmin.save_course') }}" method="POST" id="newUser_form">
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
</div>
@endsection

@section('page_custom_script')
<script>
    $(function() {
        // Modal form validation
        $.validator.setDefaults({
            submitHandler: function (form) {
                form.submit();
            }
        });

        // New course modal form validation
        $('#newUser_form').validate({
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

        // Initialize User table
        var usersTable = $('#tbl_users').DataTable({
            ajax: "{{ route('superadmin.get_users') }}",
            columns: [
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return data.first_name + " " + (data.middle_name == null ? "" : data.middle_name[0] + ".") + " " + data.last_name + " " + (data.suffix == null ? "" : data.suffix)
                    }
                },
                {
                    data: null, 
                    render: function(data, type, row, meta) {
                        if(data.role == 1) {
                            return "Admission"
                        } else if(data.role == 2) {
                            return "Program Chairperson"
                        } else if(data.role == 0) {
                            return "Superadmin"
                        }
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        if(data.role == 0) {
                            return '<button type="button" class="btn btn-primary btn-sm editCourseBtn" title="Edit"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-warning btn-sm deleteCourseBtn" title="Delete" disabled><i class="fa fa-trash-alt"></i></button>'
                        } else {
                            return '<button type="button" class="btn btn-primary btn-sm editCourseBtn" title="Edit"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-warning btn-sm deleteCourseBtn" title="Delete"><i class="fa fa-trash-alt"></i></button>'
                        }
                    }
                },
            ],
            responsive: true, 
            lengthChange: false, 
            autoWidth: false,
        });

        // Delete button function
        usersTable.on('click', 'td button.deleteCourseBtn', function() {
            var data = usersTable.row($(this).parents('tr')).data();
            Swal.fire({
                title: "Delete Confirmation",
                text: "Are you sure you want to delete this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "Cancel"
            }).then(function(result) {
                if(result.value) {
                    $.ajax({
                        url: "{{ url('/superadmin/user') }}/" + data.id,
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

                            usersTable.ajax.reload();
                        },
                        error: function(xhr, response, error) {
                            console.log(error);
                        }
                    });
                }
            });
        })
    })
</script>
@endsection