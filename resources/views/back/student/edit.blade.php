@extends('back.layout.layout', [$title = 'Update student'])


@section('content')
<div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-square-controls">Update student</h4>
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
          <form class="form" action="{{ route('student.update', $student->id) }}" method="POST">
            @csrf
            <div class="form-body">
              
              <div class="form-group">
                <label for="name">Name</label>
                <input value="{{ $student->name }}" type="text" id="name" class="form-control square {{ $errors->has('name') ? 'is-invalid' : ''}} " placeholder="Name" name="name">
                @if ($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
              </div>

              <div class="form-group">
                <label for="phone">Phone</label>
                <input value="{{ $student->phone }}" type="text" id="phone" class="form-control square {{ $errors->has('phone') ? 'is-invalid' : ''}} " placeholder="Phone" name="phone">
                @if ($errors->has('phone'))
                    <small class="text-danger">{{ $errors->first('phone') }}</small>
                @endif
              </div>

              <div class="form-group">
                <label for="course_id">Course ID</label>
                <select class="select2 form-control" name="course_id">
                  @foreach ($courses as $course)
                  <option value="{{ $course->id }}">{{ $course->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('course_id'))
                    <small class="text-danger">{{ $errors->first('course_id') }}</small>
                @endif
              </div>

             

              <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="{{ STATUS_ACTIVE }}">Public</option>
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