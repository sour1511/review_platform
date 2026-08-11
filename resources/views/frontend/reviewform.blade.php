<style>
    .fa-star {
        font-size: 25px;
        align-content: center;
    }

    .ui-widget-header {
        border: 1px solid #329a8f !important;
        background: #329a8f !important;
    }

    .swal-title {
        font-size: 24px;
        font-weight: bold;
        color: black;
    }

    .swal-modal .swal-text {
        text-align: justify;
        color: black;
    }
</style>
{{-- <div class="container mt-3 mb-3"> --}}
<div class="row">
    <div class="col-md-12 col-sm-12 mb-3">
        <!-- Basic Info -->
        <div class="tr-single-box">
            <div class="tr-single-header">
                <h4><i class="fa fa-comment-o"></i> <b>{{ __('messages.Add_a_Review') }}</b></h4>
            </div>

            <form id="submit_review_form" enctype="multipart/form-data">
                @csrf
                <div class="tr-single-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="type">{{ __('messages.Review_Type') }}</label>
                                <select name="type" id="type" class="js-states form-control"
                                    oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                    onchange="setCustomValidity('')" required>
                                    <option value="" selected disabled hidden>
                                        {{ __('messages.Choose_the_Review_Type') }}</option>
                                    <option value="Commendation">{{ __('messages.Commendation') }}</option>
                                    <option value="Complaint">{{ __('messages.Complaint') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('messages.Upload_Proof_Documents') }}</label>
                                <br>
                                <span class="text-warning"
                                    style="font-size: 12px;">{{ __('messages.upload_proof_desc') }}</span>
                                <div class="custom-file">
                                    {{-- oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')" onchange="setCustomValidity('')" --}}
                                    <input type="file" name="doc" class="custom-file-input"
                                        onchange="validateDoc(this)" id="doc_up">
                                    <label class="custom-file-label"
                                        for="doc_up">{{ __('messages.Choose_file') }}</label>
                                </div>
                            </div>
                            <span class="text-warning float-right"
                                style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="from_date">{{ __('messages.Select_from_date') }}</label>
                                <br>
                                <span class="text-warning"
                                    style="font-size: 12px;">{{ __('messages.from_date_desc') }}</span>
                                <input class="date form-control"
                                    oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                    onchange="setCustomValidity('')" id="fromDate" name="from_date"
                                    onkeydown="return false" autocomplete="new-from_date"
                                    placeholder="{{ __('messages.from') }}" type="text" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="to_date">{{ __('messages.Select_to_date') }}</label>
                                <br>
                                <span class="text-warning"
                                    style="font-size: 12px;">{{ __('messages.to_date_desc') }}</span>
                                <input class="todate form-control"
                                    oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                    onchange="setCustomValidity('')" id="toDate" name="to_date"
                                    onkeydown="return false" autocomplete="new-to_date"
                                    placeholder="{{ __('messages.to') }}" type="text" required>
                            </div>
                        </div>

                        {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="nickname">Nickname</label>
                                <input class="form-control" name="nickname" minlength="2" maxlength="25"
                                    placeholder="Please add nickname" type="text">
                            </div>
                        </div> --}}

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="location">{{ __('messages.location') }}</label>
                                {{-- <input class="form-control" name="location" placeholder="Please add location"
                                    type="text" required> --}}
                                <br>
                                <span class="text-warning"
                                    style="font-size: 12px;">{{ __('messages.location_desc') }}</span>
                                <input type="text" id="address-input" name="location"
                                    oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                    oninput="setCustomValidity('')" placeholder="{{ __('messages.location') }}"
                                    onpaste="return false;" class="form-control map-input" required>
                                <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                            </div>
                        </div>
                        <div class="d-none" id="address-map-container" style="width:100%;height:400px; ">
                            <div style="width: 100%; height: 100%" id="address-map"></div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('messages.Upload_updated_profile_image') }}<span class="text-warning"
                                        style="font-size: 12px;"> ({{ __('messages.Optional') }})</span></label><br>
                                <span class="text-warning"
                                    style="font-size: 12px;">{{ __('messages.profile_pic_desc') }}</span>
                                <div class="custom-file">
                                    <input type="file" name="updated_img" accept="image/*" class="custom-file-input"
                                        onchange="validateProfilePic(this)" id="updated_img">
                                    <label class="custom-file-label"
                                        for="updated_img">{{ __('messages.Choose_file') }}</label>
                                </div>
                            </div>
                            <span class="text-warning float-right"
                                style="font-size: 12px;">{{ __('messages.file_size_desc') }}</span>
                        </div>
                        {{-- show star rating --}}
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="con">
                                    <label
                                        for="vist_date">{{ __('messages.Add_Positive_or_Negative_Ratings') }}</label><br>
                                    <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.5_Thumbs_d') }}" id="stm5"></i>
                                    <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.4_Thumbs_d') }}" id="stm4"></i>
                                    <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.3_Thumbs_d') }}" id="stm3"></i>
                                    <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.2_Thumbs_d') }}" id="stm2"></i>
                                    <i class="fa fa-thumbs-down fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.1_Thumb_d') }}" id="stm1"></i>
                                    <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.1_Thumb') }}" id="st1"></i>
                                    <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.2_Thumbs') }}" id="st2"></i>
                                    <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.3_Thumbs') }}"id="st3"></i>
                                    <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.4_Thumbs') }}" id="st4"></i>
                                    <i class="fa fa-thumbs-up fa-lg" style="color:black" aria-hidden="true"
                                        title="{{ __('messages.5_Thumbs') }}"id="st5"></i>
                                </div>
                            </div>
                            <span class="text-danger error-text rating_error"></span>
                        </div>
                        <input type="hidden" name="rating_star" id="total_star" value="0">
                        <input type="hidden" name="category_id" value="{{ $data['profilesData']->category_id }}">
                        <input type="hidden" name="sub_category_id"
                            value="{{ $data['profilesData']->sub_category_id }}">
                        <input type="hidden" name="profile_id" value="{{ $data['profilesData']->id }}">

                        <input type="hidden" name="post_date" id="post_date">
                        <input type="hidden" name="post_time" id="post_time">
                        <input type="hidden" name="timezone" id="timezone">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <span class="text-warning"
                                    style="font-size: 12px;">{{ __('messages.Add_Positive_desc') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('messages.Add_a_Review') }}</label><br>
                                <div id="summernotes">
                                    <textarea class="full-width" onChange="maxlength(this, 200)"
                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')" oninput="setCustomValidity('')"
                                        pattern="^(?:\b\w+\b[\s\r\n]*){1,200}$" name="review" id="review" required style="height: 100px"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <input type="checkbox" name="agree" id="agree" value="1">
                                <label for="remember">I accept terms and condition</label>
                                <br>
                                <label class="text-warning">If you check this box then you review is verified otherwise
                                    not, you need to
                                    upload the support document of your reviews if required in future.</label>
                            </div>
                        </div> --}}

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="">{{ __('messages.shown_as_verified') }}</label><br>
                            <input type="radio" id="yes" name="agree" value="1">
                            <label for="yes" class="mr-1">{{ __('messages.yes') }}</label>
                            <input type="radio" id="no" name="agree" value="0">
                            <label for="no">{{ __('messages.no') }}</label><br>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 d-none realname">
                            <label for="">{{ __('messages.real_name_Yes_No') }}</label><br>
                            <input type="radio" id="real_yes" name="real" value="1">
                            <label for="real_yes" class="mr-1">{{ __('messages.yes') }}</label>
                            <input type="radio" id="real_no" name="real" value="0">
                            <label for="real_no">{{ __('messages.no') }}</label><br>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button type="submit" id="reviewSubmit"
                                    class="btn btn-info btn-md ml-3 float-right">{{ __('messages.Submit_Your_Review') }}</button>
                                {{-- <a href="#" class="btn btn-info btn-md full-width">Submit Review<i class="ml-2 ti-arrow-right"></i></a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Basic Info -->
    </div>
</div>
{{-- </div> --}}

@section('mainscript')
    @parent
    <script>
        // $('#reviewSubmit').on("click", function(e) {
        //     e.preventDefault();
        //     if ($("#total_star").val() == 0) {
        //         alert('{{ __('messages.fill_out') }}');
        //         return false;
        //     }
        // });

        $('#submit_review_form').on('submit', function(e) {
            e.preventDefault();

            if ($("#total_star").val() == 0) {
                $(".rating_error").html("{{ __('messages.fill_out') }}");
                $("#total_star").focus();
                return false;
            } else {
                $(".rating_error").html("");
            }

            $.ajax({
                url: "{{ Route('submit_review') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                        $.each(data.error, function(prefix, val) {
                            // console.log(val);
                            // console.log(prefix);
                            // $('span.' + prefix + '_error').text(val[0]);


                        });

                    } else {
                        // $('#regSubmit').prop('disabled', false);                       
                        $('#submit_review_form').get(0).reset();
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            location.reload();
                        });
                    }
                }
            });


        });


        function maxlength(element, maxvalue) {
            var q = element.value.split(/[\s]+/).length;
            if (q > maxvalue) {
                var r = q - maxvalue;
                $('#reviewSubmit').prop('disabled', true);
                var errortext = "{{ __('messages.you_have_input') }}" + q +
                    "{{ __('messages.words_into_the') }}" +
                    "{{ __('messages.Review_area_box_you') }}" + maxvalue +
                    "{{ __('messages.words_to_be') }}" +
                    "{{ __('messages.your_text_by') }}" + r + "{{ __('messages.words') }}";
                alert(errortext);

                return false;
            }
            $('#reviewSubmit').prop('disabled', false);
        }

        $(document).ready(function() {
            $('#yes').on("click", function() {
                // $("#doc_up").prop('required', true);
                $("#doc_up").attr('required', 'required');
                // $("#doc_up").attr('required', true);
                $(".realname").addClass('d-none');

                swal({
                    title: "{{ __('messages.Terms_and_Conditions') }}",
                    type: "warning",
                    text: "{{ __('messages.yes_no') }}",
                    icon: "warning",
                    showConfirmButton: true
                });
            });

            $('#no').on("click", function() {
                // $("#doc_up").prop('required', false);
                // $('#doc_up').attr('required', false);
                $('#doc_up').removeAttr('required');
                // var fileValidity = $('#doc_up').validity;
                // fileValidity.setCustomValidity('');
                $(".realname").removeClass('d-none');
            });
        });

        function validateDoc(file) {
            var re = /(\.pdf|\.docx|\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_doc') }}");
                $('#doc_up').val('');
                $('#doc_up').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#doc_up').val('');
                $('#doc_up').text('Choose file');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        function validateProfilePic(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#updated_img').val('');
                $('#updated_img').text('Choose file');
            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#updated_img').val('');
                $('#updated_img').text('Choose file');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
        }

        $(document).ready(function() {
            var todayDate = moment();
            setInterval(runningTime, 1000);

            // var dateC = "";
            // $(function() {
            //     $("#fromDate").datepicker({
            //         dateFormat: 'yy-mm-dd',
            //         autoclose: true
            //     });
            // });

            // $(function() {
            //     $("#toDate").datepicker({
            //         dateFormat: 'yy-mm-dd',
            //         autoclose: true
            //     });
            // });
            var lang = $('#langSelected').val();
            // alert(lang);
            $(function() {

                $("#fromDate").datepicker({
                    format: 'yyyy-mm-dd',
                    endDate: todayDate.toDate(),
                    language: lang,
                    autoclose: true
                }).on('changeDate', function(selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#toDate').datepicker('setStartDate', minDate);
                });
            });

            $(function() {
                $("#toDate").datepicker({
                    format: 'yyyy-mm-dd',
                    endDate: todayDate.toDate(),
                    language: lang,
                    autoclose: true
                }).on('changeDate', function(selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#fromDate').datepicker('setEndDate', minDate);
                });
            });

            // $('#fromDate').change(function() {
            //     startDate1 = $(this).datepicker('getDate');
            //     $("#toDate").datepicker("option", "minDate", startDate1);
            // });

            // $('#toDate').change(function() {
            //     endDate1 = $(this).datepicker('getDate');
            //     $("#fromDate").datepicker("option", "maxDate", endDate1);
            // });


            // $("#to_date").datepicker({
            // dateFormat: 'yy-mm-dd',
            // changeMonth: true
            // });
            // $('.date').datepicker({
            // format: 'yyyy-mm-dd',
            // endDate: '+0d',
            // autoclose: true
            // }).on('changeDate', function(e) {
            // // console.log(e.format());
            // // var start = e.format();
            // // var dateC = moment(start, "YYYY-MM-DD").add(1, 'd').format("YYYY-MM-DD");
            // });

            // minDate:today,
            // startDate:end,
            // endDate:start
            // $(".date").datepicker({
            // showOn: "both",
            // // format: 'yyyy-mm-dd',
            // // endDate: '+0d',
            // autoclose: true,
            // onSelect: function(dateText, inst) {
            // $(".todate").datepicker("option", "minDate", $(".date").datepicker(
            // "getDate"));
            // }
            // });

            // $('.todate').datepicker();




            function runningTime() {
                // console.log(Intl.DateTimeFormat().resolvedOptions().timeZone);
                const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                const currentTime = moment(new Date(), "YYYY-MM-DD hh:mm:ss").tz(timezone).format(
                    "hh:mm:ss");
                const currentDate = moment(new Date(), "YYYY-MM-DD hh:mm:ss").tz(timezone).format(
                    "YYYY-MM-DD");
                // console.log(currentTime);
                // console.log(currentDate);

                $('#post_date').val(currentDate);
                $('#post_time').val(currentTime);
                $('#timezone').val(timezone);
                var currentTimedata = currentDate + ' ' + currentTime;
                $.ajax({
                    url: "{{ Route('set_currenttime_user') }}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'current_time': currentTimedata,
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 0) {} else {}
                    }
                });
            }


            $("#st1").click(function() {
                if ($("#st1").css("color") == "rgb(255, 165, 52)") {
                    $(".con .fa-thumbs-up").css("color", "black");
                    $(".con .fa-thumbs-down").css("color", "black");
                    $("#total_star").val("0");
                } else {
                    $(".con .fa-thumbs-up").css("color", "black");
                    $(".con .fa-thumbs-down").css("color", "black");
                    $("#st1").css("color", "#ffa534");
                    $("#total_star").val("1");
                }
            });
            $("#st2").click(function() {
                $(".con .fa-thumbs-up").css("color", "black");
                $(".con .fa-thumbs-down").css("color", "black");
                $("#st1, #st2").css("color", "#ffa534");
                $("#total_star").val("2");
            });
            $("#st3").click(function() {
                $(".con .fa-thumbs-up").css("color", "black")
                $(".con .fa-thumbs-down").css("color", "black");
                $("#st1, #st2, #st3").css("color", "#ffa534");
                $("#total_star").val("3");
            });
            $("#st4").click(function() {
                $(".con .fa-thumbs-up").css("color", "black");
                $(".con .fa-thumbs-down").css("color", "black");
                $("#st1, #st2, #st3, #st4").css("color", "#ffa534");
                $("#total_star").val("4");
            });
            $("#st5").click(function() {
                $(".con .fa-thumbs-up").css("color", "black");
                $(".con .fa-thumbs-down").css("color", "black");
                $("#st1, #st2, #st3, #st4, #st5").css("color", "#ffa534");
                $("#total_star").val("5");
            });

            // #ff4545 red star color

            $("#stm1").click(function() {
                if ($("#stm1").css("color") == "rgb(255, 69, 69)") {
                    $(".con .fa-thumbs-down").css("color", "black");
                    $(".con .fa-thumbs-up").css("color", "black");
                    $("#total_star").val("0");
                } else {
                    $(".con .fa-thumbs-down").css("color", "black");
                    $(".con .fa-thumbs-up").css("color", "black");
                    $("#stm1").css("color", "#ff4545");
                    $("#total_star").val("-1");
                }
            });

            $("#stm2").click(function() {
                $(".con .fa-thumbs-down").css("color", "black");
                $(".con .fa-thumbs-up").css("color", "black");
                $("#stm1,#stm2").css("color", "#ff4545");
                $("#total_star").val("-2");
            });

            $("#stm3").click(function() {
                $(".con .fa-thumbs-down").css("color", "black");
                $(".con .fa-thumbs-up").css("color", "black");
                $("#stm1,#stm2,#stm3").css("color", "#ff4545");
                $("#total_star").val("-3");
            });

            $("#stm4").click(function() {
                $(".con .fa-thumbs-down").css("color", "black");
                $(".con .fa-thumbs-up").css("color", "black");
                $("#stm1,#stm2,#stm3,#stm4").css("color", "#ff4545");
                $("#total_star").val("-4");
            });

            $("#stm5").click(function() {
                $(".con .fa-thumbs-down").css("color", "black");
                $(".con .fa-thumbs-up").css("color", "black");
                $("#stm1,#stm2,#stm3,#stm4,#stm5").css("color", "#ff4545");
                $("#total_star").val("-5");
            });
        });
    </script>
@endsection
