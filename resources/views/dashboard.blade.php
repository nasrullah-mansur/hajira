@extends('back.layout.layout', [$title = 'dashboard'])

@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">00</h3>
                            <span>Total Posts</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="ft-book primary font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection
