@extends('back.layout.layout', [$title = 'Attendance'])

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('back/vendors/css/pickers/pickadate/pickadate.css') }}">
@endpush

@section('content')
<section id="html5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Attendance</h4>
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
                    <div class="card-body card-dashboard">
                        <form method="POST" id="course-form">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-body">

                                        <div class="error_msgs d-none mb-1 p-1 bg-danger text-white">
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="course_id">Course ID</label>
                                            <select id="course_id" class="select2 form-control" name="course_id">
                                                <option selected disabled>Select One</option>
                                                @foreach ($courses as $course)
                                                <option value="{{ $course }}">{{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group attendance-type-group">
                                            <label>Attendance Type</label>
                                            <select id="type" class="form-control" name="type">
                                                <option selected disabled>Select One</option>
                                                <option value="new">New Attendance</option>
                                                <option value="old">Edit Attendance</option>
                                            </select>
                                        </div>
                                        <div class="form-group class-no-group d-none">
                                            <label for="class_no_data">Which class do you want to edit?</label>
                                            <select id="class_no_data" class="select2 form-control" name="class_no_data"></select>
                                        </div>
                                        <div class="form-group pick-date-group d-none">
                                            <div class="form-group">
                                                <label>Select a date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <span class="fa fa-calendar-o"></span>
                                                        </span>
                                                    </div>
                                                    <input name="date" type='text' class="form-control pickadate" placeholder="Pick-a-date" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions border-0 p-0">
                                            <button type="submit" class="btn btn-info" style="margin-right: 5px;">
                                                <i class="fa fa-chevron-right"></i> Continue
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="rounded bg-info circle p-5 mt-2 text-white text-center">
                                        <p class="h1 text-bold">
                                            <span class="d-block">Class</span>
                                            <span id="completed_class">0</span>/<span id="total_class_count">0</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 give-attendance-area d-none">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Give Attendance</h4>
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
                    <div class="card-body card-dashboard" >
                        <form id="student_attendance">
                            <input type="hidden" name="f_course_id">
                            <input type="hidden" name="f_type">
                            <input type="hidden" name="f_date">
                            <input type="hidden" name="f_class_no_data">

                            <div id="student_item_area">

                            </div>

                            <div class="form-actions text-right border-0 p-0">
                                <button type="submit" class="btn btn-info" style="margin-right: 5px;">
                                    <i class="fa fa-chevron-right"></i> Save Attendance
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('custom_js')
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('back/vendors/js/pickers/dateTime/moment-with-locales.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('back/vendors/js/pickers/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('back/vendors/js/pickers/pickadate/picker.date.js') }}" type="text/javascript"></script>

<script>
    $('.pickadate').pickadate();

    let attendance_type = 'new';
    let completed_class = null;
    let total_class_of_course = 0;

    let class_no_option = function(total) {
        let options = ['<option selected disabled>Select One</option>'];
        for (let i = 1; i <= total; i++) {
            options.push(`<option value="${i}">Class No: ${i}</option>`);
        }
        return options.join('');
    }

    $('#type').on('change', function() {
        attendance_type = $(this).val();
        $('[name="f_type"]').val(attendance_type);
        $('.error_msgs').addClass('d-none');

        if (attendance_type === 'old') {
            $('.class-no-group').removeClass('d-none');
            $('.pick-date-group').addClass('d-none');
            $('#class_no_data').html(class_no_option(completed_class));
        } else {
            $('.class-no-group').addClass('d-none');
            $('.pick-date-group').removeClass('d-none');
        }
    })

    $('#course_id').on('change', function() {
        let course = JSON.parse($(this).val());
        let course_view_url = "{{ route('attendance.view') }}";
        $('.error_msgs').addClass('d-none');

        $('[name="f_course_id"]').val(course.id);

        $.ajax({
            type: "POST",
            url: course_view_url,
            data: {
                id: course.id,
                attendance_type,
            },
            success: function(res) {
                total_class_of_course = course.total_class;
                $('#total_class_count').text(total_class_of_course);
                completed_class = res;
                $('#completed_class').text(completed_class);
                $('#class_no_data').html(class_no_option(completed_class));
            }
        })
    });

    $('#course-form').on('submit', function(e) {
        e.preventDefault();

        let formdata = $(this).serializeArray();
        let create_url = "{{ route('attendance.create') }}";
        
        var formDataObject = formdata.reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        $.ajax({
            type: "POST",
            url: create_url,
            data: formDataObject,
            success: function(students) {
                $('#student_item_area').html(studentItem(students));

                $('.skin-square input').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                });

                studentItemCheckbox();
                $('.give-attendance-area').removeClass('d-none');
            }
        })
    });

    $('[name="date"]').on('change', function() {
        $('[name="f_date"]').val(this.value);
        $('.error_msgs').addClass('d-none');
    })

    $('[name="class_no_data"]').on('change', function() {
        $('[name="f_class_no_data"]').val(this.value);
        $('.error_msgs').addClass('d-none');
    })

    $('#student_attendance').on('submit', function(e) {
        e.preventDefault();
        let course_id = $('[name="f_course_id"]').val();
        let type = $('[name="f_type"]').val();
        let class_no_data = $('[name="f_class_no_data"]').val();
        let date = $('[name="f_date"]').val();

        let finalData = {
            course_id,
            type,
            class_no_data,
            date
        };

        const studentItems = document.querySelectorAll('.student-item');
        const students = [];

        studentItems.forEach(item => {
            const student = {
                student_id: item.querySelector('input[name="student_id"]').value,
                student_name: item.querySelector('input[name="student_name"]').value,
                present: item.querySelector('input[name="present"]').value,
                homework: item.querySelector('input[name="homework"]').value,
                total_present: totalCount(item.querySelector('input[name="total_present"]').value, item.querySelector('input[name="present"]').value) ,
                total_homework: totalCount(item.querySelector('input[name="total_homework"]').value,item.querySelector('input[name="homework"]').value) 
            };
            students.push(student);
        });
       

        function totalCount(prev, status) {
            if (type == 'new') {
                // Add;
                if (prev == 'undefined') {
                    if (status == 'yes') {
                        return 1;
                    } else {
                        return 'undefined';
                    }
                }

                // Edit;
                else {
                    if (status == 'yes') {
                        return Number(prev) + 1;
                    } else {
                        return prev;
                    }
                }
            }
        }

        let create_url = "{{ route('attendance.store') }}";
        
        $.ajax({
            type: "POST",
            url: create_url,
            data: { ...finalData, attendances: students },
            success: function(response) {
                $('.give-attendance-area').addClass('d-none');
                $('#course-form')[0].reset();
                completed_class = Number(completed_class) + 1;
                $('#completed_class').text(completed_class);
            },
            error: function(err) {
                let errors = err.responseJSON.errors;
                let errorsMsgs = Object.values(errors).reduce((acc, messages) => acc.concat(messages), []);

                let errorsMsgsElements = errorsMsgs.map((item) => {
                    return `<span class="d-block">${item}</span>`;
                })

                $('.error_msgs').removeClass('d-none').html(errorsMsgsElements.join(''));
            }
        })
    })

    function studentItem(students) {
        let data = students.map(function(e, index) {
            return (`
                <div class="student-item p-1 mb-1 bg-info bg-lighten-2 d-flex align-items-center">
                    <input type="hidden" value="${e.id}" name="student_id" />
                    <input type="hidden" value="${e.name}" name="student_name" />
                    <input type="hidden" value="${e.total_present}" name="total_present" />
                    <input type="hidden" value="${e.total_homework}" name="total_homework" />
                    <h4 class="m-0" style="font-size: 22px;">
                        <span class="d-inline-block"><span class="d-inline-block" style="width: 30px;">${index + 1}.</span> ${e.name}</span>
                    </h4>
                    <strong class="ml-auto" style="font-size: 18px; margin-right: 20px;">
                        T.P - ${e.total_present} / T.H - ${e.total_homework}
                    </strong>
                    <div class="align-right d-flex">
                        <div class="bg-white d-flex align-items-center" style="padding: 5px 10px; margin-right: 5px;">
                            <input type="hidden" value="${e.present ? e.present : 'no'}" name="present" />
                            <label class="custom_checkbox ${e.present == 'yes' ? 'active' : ''} m-0 cursor-pointer">Present</label>
                        </div>
                        <div class="bg-white d-flex align-items-center" style="padding: 8px 15px;">
                            <input type="hidden" value="${e.homework ? e.homework : 'no'}" name="homework" />
                            <label class="custom_checkbox ${e.homework == 'yes' ? 'active' : ''} m-0 cursor-pointer">Homework</label>
                        </div>
                    </div>
                </div>
            `);
        });

        return data.join('');
    }

    function studentItemCheckbox() {
        $('.student-item .custom_checkbox').on('click', function() {
            $(this).toggleClass('active');
            $(this).parent().find('input').val(function() {
                if ($(this).parent().find('input').val() == 'no') {
                    return 'yes';
                } else {
                    return 'no';
                }
            });
        })
    }


</script>
@endpush
