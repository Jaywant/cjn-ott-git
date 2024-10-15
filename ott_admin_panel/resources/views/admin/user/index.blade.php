@extends('admin.layout.page-app')
@section('page_title', __('label.users'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.users')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.users')}}</li>
                    </ol>
                </div>
                <!-- <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('user.create') }}" class="btn btn-default mw-120" style="margin-top: -14px;">{{__('label.add_user')}}</a>
                </div> -->
            </div>

            <!-- Export Files -->
            <div class="page-search mb-3">
                <div class="col-8">
                    <label class="text-gray pt-2 font-weight-bold"><i class="fa-solid fa-circle-info fa-2xl mr-3"></i>{{__('label.only_the_following_data_will_be_captured_in_this_file')}}</label>
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-around">
                        <button id="ms_excel" class="btn btn-default" title="{{__('label.download_ms_excel')}}"><i class="fa-sharp fa-solid fa-file-excel mr-2 font-weight-bold"></i>{{__('label.ms_excel')}}</button>
                        <button id="csv" class="btn btn-default" title="{{__('label.download_csv')}}"><i class="fa-solid fa-file-csv mr-2 font-weight-bold" style="font-size:18px"></i>{{__('label.csv')}}</button>
                        <button id="pdf" class="btn btn-default" title="{{__('label.download_pdf')}}"><i class="fa-solid fa-file-pdf mr-2 font-weight-bold" style="font-size:18px"></i>{{__('label.pdf')}}</button>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="page-search mb-3">
                <div class="input-group" title="{{__('label.search')}}">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i></span>
                    </div>
                    <input type="text" id="input_search" class="form-control" placeholder="{{__('label.search_users')}}" aria-label="Search" aria-describedby="basic-addon1">
                </div>
                <div class="sorting mr-4">
                    <label>{{__('label.sort_by')}}</label>
                    <select class="form-control" id="input_type">
                        <option value="all">{{__('label.all')}}</option>
                        <option value="today">{{__('label.today')}}</option>
                        <option value="month">{{__('label.month')}}</option>
                        <option value="year">{{__('label.year')}}</option>
                    </select>
                </div>
                <div class="sorting">
                    <label>{{__('label.sort_by')}}</label>
                    <select class="form-control" id="input_login_type">
                        <option value="all">{{__('label.all_type')}}</option>
                        <option value="1">{{__('label.otp')}}</option>
                        <option value="2">{{__('label.google')}}</option>
                        <option value="3">{{__('label.apple')}}</option>
                        <option value="4">{{__('label.normal')}}</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive table">
                <table class="table table-striped text-center table-bordered" id="datatable">
                    <thead>
                        <tr style="background: #F9FAFF;">
                            <th>{{__('label.#')}}</th>
                            <th>{{__('label.image')}}</th>
                            <th>{{__('label.full_name')}}</th>
                            <th>{{__('label.email')}}</th>
                            <th>{{__('label.mobile')}}</th>
                            <th>{{__('label.register_date')}}</th>
                            <th>{{__('label.type')}}</th>
                            <th>{{__('label.login_type_1_OTP_2_Google_3_Apple_4_Normal')}}</th>
                            <th>{{__('label.action')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                dom: "<'top'f>rt<'row'<'col-2'i><'col-1'l><'col-9'p>>",
                searching: false,
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 100, 500, -1],
                    [10, 100, 500, "All"]
                ],
                language: {
                    paginate: {
                        previous: "<i class='fa-solid fa-chevron-left'></i>",
                        next: "<i class='fa-solid fa-chevron-right'></i>"
                    }
                },
                ajax:
                    {
                    url: "{{ route('user.index') }}",
                    data: function(d){
                        d.input_type = $('#input_type').val();
                        d.input_login_type = $('#input_login_type').val();
                        d.input_search = $('#input_search').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return "<a href='" + data + "' target='_blank' title='{{__('label.watch')}}'><img src='" + data + "' class='rounded-circle' style='height:55px; width:55px'></a>";
                        },
                    },
                    {
                        data: 'full_name',
                        name: 'full_name',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'mobile_number',
                        name: 'mobile_number',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            if (data == 1) {
                                return "<i class='fa-solid fa-mobile-screen-button fa-3x' title='{{__('label.otp')}}'></i>";
                            } else if (data == 2) {
                                return "<i class='fa-brands fa-google fa-3x' title='{{__('label.google')}}'></i>";
                            } else if (data == 3) {
                                return "<i class='fa-brands fa-apple fa-3x' title='{{__('label.apple')}}'></i>";
                            } else if (data == 4) {
                                return "<i class='fa-solid fa-lock fa-3x' title='{{__('label.normal')}}'></i>";
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'type',
                        name: 'Login Type',
                        orderable: false,
                        searchable: false,
                        visible: false,
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                buttons: [{
                        extend: 'excel',
                        filename: "{{App_Name()}} - {{__('label.users')}}",
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 7]
                        },
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '2');
                        },
                    },
                    {
                        extend: 'csv',
                        filename: "{{App_Name()}} - {{__('label.users')}}",
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 7]
                        },
                    },
                    {
                        extend: 'pdf',
                        title: "{{App_Name()}} - {{__('label.users')}}",
                        filename: "{{App_Name()}} - {{__('label.users')}}",
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 7]
                        },
                        customize: function(doc) {
                            doc.styles.tableHeader.fontSize = 10; //2, 3, 4, etc
                            doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                            doc.content[1].table.widths = ['5%', '20%', '20%', '20%', '15%', '20%'];
                            doc.content[1].layout = "borders";
                            doc.styles.title.fontSize = 22;
                            doc.styles.title.alignment = 'center';
                            doc.defaultStyle.alignment = 'center';

                            // Create a header
                            doc['header'] = (function(page, pages) {
                                return {
                                    columns: [{
                                            alignment: 'left',
                                            bold: true,
                                            text: "{{App_Name()}}",
                                        },
                                        {
                                            alignment: 'right',
                                            bold: true,
                                            text: ['Total Page ', {
                                                text: pages.toString()
                                            }],
                                        }
                                    ],
                                    margin: [20, 20],
                                }
                            });
                            // Create a footer
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                        alignment: 'center',
                                        bold: true,
                                        text: ['Page ', {
                                            text: page.toString()
                                        }, ' of ', {
                                            text: pages.toString()
                                        }],
                                    }],
                                }
                            });
                        }
                    }
                ],
            });

            $('#ms_excel').on('click', function() {

                var check_access = '{{Check_Admin_Access()}}';
                if (check_access == 1) {
                    var table = $('#datatable').DataTable();
                    table.button('0').trigger();
                } else {
                    toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
                }
            });
            $('#csv').on('click', function() {

                var check_access = '{{Check_Admin_Access()}}';
                if (check_access == 1) {
                    var table = $('#datatable').DataTable();
                    table.button('1').trigger();
                } else {
                    toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
                }
            });
            $('#pdf').on('click', function() {

                var check_access = '{{Check_Admin_Access()}}';
                if (check_access == 1) {
                    var table = $('#datatable').DataTable();
                    table.button('2').trigger();
                } else {
                    toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
                }
            });

            $('#input_type, #input_login_type').change(function(){
                table.draw();
            });
            $('#input_search').keyup(function(){
                table.draw();
            });
        });
    </script>
@endsection