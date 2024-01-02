@extends('../base')

@section('title', 'Subjects')

@section('map_site')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Subjects</h1>
    </div><!-- /.col -->

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admission.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Subjects</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
<div class="card">
    &nbsp;
</div>
@endsection

@section('page_custom_script')
<script>

</script>
@endsection