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
    <div class="container-fluid p-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div class="border-bottom pb-4 mb-4">              
                    <h3 class="mb-0 fw-bold">Unverified Accounts</h3>             
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center border-0">
                        <span></span>
                        <button class="btn btn-primary">+ Add</button>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered" style="width: 100%;">
                            <thead class="table-light">
                                <th scope="col">ID</th>
                                <th scope="col">Description</th>
                                <th scope="col">Qty</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>test</td>
                                    <td>test</td>
                                    <td>test</td>
                                </tr>
                                <tr>
                                    <td>tes123t</td>
                                    <td>tes123t</td>
                                    <td>te123sst</td>
                                </tr>
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
            $('#datatable').DataTable();
        });
    </script>
@endpush