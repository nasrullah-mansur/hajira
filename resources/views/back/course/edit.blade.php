@extends('back.layout.layout', [$title = 'Update course'])


@section('content')
<div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-square-controls">Update course</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            <li><a data-action="close"><i class="ft-x"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-content collapse show">
        <div class="card-body">
          <form class="form" action="{{ route('course.update', $course->id) }}" method="POST">
            @csrf
            <div class="form-body">
            
              <div class="form-group">
                <label for="name">Name</label>
                <input value="{{ $course->name }}" type="text" id="name" class="form-control square {{ $errors->has('name') ? 'is-invalid' : ''}} " placeholder="Name" name="name">
                @if ($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
              </div>

              <div class="form-group">
                <label for="total_class">Total Class</label>
                <input value="{{ $course->total_class }}" type="number" id="total_class" class="form-control square {{ $errors->has('total_class') ? 'is-invalid' : ''}} " placeholder="Total Class" name="total_class">
                @if ($errors->has('total_class'))
                    <small class="text-danger">{{ $errors->first('total_class') }}</small>
                @endif
              </div>

              <div class="form-group">
                <label for="total_module">Total Module</label>
                <input value="{{ $course->total_module }}" type="number" id="total_module" class="form-control square {{ $errors->has('total_module') ? 'is-invalid' : ''}} " placeholder="Total Module" name="total_module">
                @if ($errors->has('total_module'))
                    <small class="text-danger">{{ $errors->first('total_module') }}</small>
                @endif
              </div>

              <div class="form-group">
                <label for="total_exam">Total Exam</label>
                <input value="{{ $course->total_exam }}" type="number" id="total_exam" class="form-control square {{ $errors->has('total_exam') ? 'is-invalid' : ''}} " placeholder="Total Exam" name="total_exam">
                @if ($errors->has('total_exam'))
                    <small class="text-danger">{{ $errors->first('total_exam') }}</small>
                @endif
              </div>

             

              <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="{{ STATUS_UPCOMING }}">Upcoming</option>
                    <option value="{{ STATUS_ACTIVE }}">Publised</option>
                    <option value="{{ STATUS_INACTIVE }}">Save Draft</option>
                </select>
              </div>
                            
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" style="margin-right: 5px; ">
                  <i class="fa fa-check-square-o"></i> Save
                </button>
              <button type="reset" class="btn btn-warning">
                <i class="ft-x"></i> Reset
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection