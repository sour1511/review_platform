@extends('layout')
@section('head')
    @parent
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
<style>
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
</style>
@section('content')
    @parent
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('messages.reviews') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.reviews') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                @if (Session::has('error'))
                    <?php $errors = Session::get('error'); ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ Session::get('error') }}
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ Session::get('success') }}
                    </div>
                @endif

                {{-- search filter --}}
                <div class="mt-3 mb-3 col-12">
                    <label for="filter">{{ __('messages.search_category') }}</label>
                    <select class="livesearch form-control" name="livesearch"></select>
                </div>

                <div id="reviewListAjaxView">
                    @include('admin.reviews_list_ajax')
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- delete pop up box -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <form role="form" method='post' action="{{ Route('reviewdelete') }}"
                class="col-xs- col-sm-12 col-md-12 col-lg-">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ __('messages.remove_review') }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' id="deleteId" name='deleteId' value="">

                        <p>{{ __('messages.delete_msg') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{ __('messages.remove') }}</button>
                        <button type="button" class="btn btn-primary"
                            data-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                    @csrf
                </div>
            </form>

        </div>
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    @parent
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).on('click', '.scrap', function(e) {
            scrapId = $(this).attr('data-id');
            $('#deleteId').val(scrapId);
        });
        $(document).ready(function() {
            $(function() {
                $("#reviewsList").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "searching": false,
                    "autoWidth": true,
                    "deferRender": true,
                    "destroy": true,
                    "buttons": ["csv", "excel", "pdf"]
                }).buttons().container().appendTo('#reviewsList_wrapper .col-md-6:eq(0)');
            });
        });
    </script>

    <script type="text/javascript">
        $('.livesearch').select2({
            placeholder: "{{ __('messages.select_category') }}",
            ajax: {
                url: "{{ Route('autocompletecategory') }}",
                dataType: 'json',
                delay: 20,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.category_title,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $(document.body).on("change", ".livesearch", function() {
            // alert(this.value);
            // call ajax function and load category data on reviews table view 
            $.ajax({
                url: "{{ Route('getreviewslist') }}",
                data: {
                    'id': this.value,
                },
                success: function(data) {
                    $('#reviewListAjaxView').html(data);
                }
            });
        });
    </script>
@endsection
