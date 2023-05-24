@extends('Layouts.Main')

@push('Sidebar')
    @include('Components.Admin.Sidebar')
@endpush

@push('Header')
    @include('Components.Admin.Header')
@endpush

@section('Content')
    <!-- Content -->
    <!-- Container fluid -->
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div class="border-bottom pb-4 mb-4">              
                    <h3 class="mb-0 fw-bold">Blocked Accounts</h3>             
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-l2 mb-2" id="live-alert">

            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center border-0">
                        <span></span>
                        <button class="btn btn-secondary btn-sm" id="table_blocked_refresh"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
                    </div>

                    <div class="card-body">
                        <table id="table_blocked" class="table table-responsive" style="width: 100%;">
                            <thead class="table-light">
                                <th scope="col">ID</th>
                                <th scope="col">Picture</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Position</th>
                                <th scope="col">Classification</th>
                                <th scope="col">Data Created</th>
                                <th scope="col">Action</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> 
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            table = $('#table_blocked').DataTable({
                ajax: {
                    url: "{{ route('Admin.Accounts.Blocked.Data.Index') }}",
                    async : false,
                    dataSrc: "data",
                },
                order: [[0, 'desc']],
                responsive: true,
                scrollX: true,
                columns: [
                    { data: 'acc_id' },
                    { data: 'acc_profile_pic' },
                    { data: 'acc_name' },
                    { data: 'acc_email' },
                    { data: 'acc_position' },
                    { data: 'acc_classification' },
                    { data: 'acc_created_date' },
                    { data: 'action' },
                ],
            });

            $('#table_blocked_refresh').click(function(){
                table.ajax.reload( alert_show('success', 'Table data refresh!'), false);           
            });
        });

        function view(btn_id, acc_id){

            var url = "{{ route('Admin.Accounts.Unverified.Data.Update', ['acc_id' => '%acc_id%']) }}".replace('%acc_id%', acc_id);
            load_btn(btn_id, true);

            $.ajax({
                type: "PUT",
                url: url,
                data : { 
                    _token: "{{ csrf_token() }}" 
                },
                enctype: 'multipart/form-data',
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);
                    table.ajax.reload(alert_show(response.icon, response.message), false);
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn(btn_id,false);
            });
        }

        function unblock(btn_id, acc_id){
            id = leftPad(acc_id, 5);
            swal({
                title: "Are you sure?",
                text: `Your about to unblock the acc no.${id}!`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var url = "{{ route('Admin.Accounts.Blocked.Data.Unblock', ['acc_id' => '%acc_id%']) }}".replace('%acc_id%', acc_id);
                    load_btn(btn_id, true);

                    $.ajax({
                        type: "PUT",
                        url: url,
                        data : { 
                            _token: "{{ csrf_token() }}" 
                        },
                        enctype: 'multipart/form-data',
                        success: function(response){
                            response = JSON.parse(response);
                            console.log(response);
                            table.ajax.reload(alert_show(response.icon, response.message), false);                          
                        },
                        error: function(response){
                            console.log(response);
                        }
                    }).always(function(){
                        load_btn(btn_id,false);
                    });
                } 
            });
        }
    </script>
@endpush