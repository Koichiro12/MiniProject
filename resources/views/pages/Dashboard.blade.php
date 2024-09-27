@extends('assets.layouts.App')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $category->count() }}</h3>

                                <p>Category</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-th"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $transactions->count() }}</h3>

                                <p>Transactions</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
                {{-- Row --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h1 class="card-title">
                                    Transactions Chart Income (Left) and Expanse (Right)
                                </h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td> <span class="badge badge-success">In</span> Income ({{$data['countIn']}})</td>
                                                    <td>: Rp {{number_format($data['amountIn'])}},-</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-danger">Out</span> Expanse ({{$data['countOut']}})</td>
                                                    <td>: Rp {{number_format($data['amountOut'])}},-</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-success">In</span> - <span class="badge badge-danger">Out</span> Total ({{$transactions->count()}})</td>
                                                    <td>: Rp {{number_format($data['amountIn'] - $data['amountOut'])}},-</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <canvas id="in-chart" height="300" style="height: 300px;">
                                        </canvas>
                                    </div>
                                    <div class="col-md-3">
                                        <canvas id="out-chart" height="300" style="height: 300px;"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h1 class="card-title">
                                    Create Transactions
                                </h1>

                            </div>
                            <form action="{{ route('Dtransactions.store') }}" method="post">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="date_input">Date</label>
                                        <input type="date" name="date_input" id="date_input" class="form-control"
                                            required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <select name="type" id="type" class="form-control" required>
                                                    <option value="in">Income (in)</option>
                                                    <option value="out">Expanse (out)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category_id">Category</label>
                                                <select name="category_id" id="category_id" class="form-control" required>
                                                    <option value="">-- Choose Category --</option>
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}">{{ $item->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" name="amount" id="amount" class="form-control" required>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary form-confirm"><i
                                            class="fas fa-save"></i>Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h1 class="card-title">
                                    Transactions
                                </h1>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="tbl_list">
                                        <thead>
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Transactions</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>

                </div>
                {{-- Ends Row --}}
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('content-js')
    <script>
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('transactions.list') }}',
                order: [
                    [3, 'desc']
                ],
                columns: [{
                        data: "id",
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'type',
                        name: 'type',
                        render: function(data, type, row, meta) {
                            return data == 'in' ? '<span class="badge badge-success">In<span>' :
                                '<span class="badge badge-danger">Out<span>'
                        }
                    },
                    {
                        data: 'detail_transactions',
                    },
                    {
                        data: "id",
                        name: "id",
                        render: function(data, type, row, meta) {
                            let id = data;
                            return '<form action="{!! url()->current() . "/'+id+'" !!}" method="POST" enctype="multipart/form-data"> @csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm form-confirm" onClick="confirmDelete(event,this)"><i class="fas fa-trash"/></button></form>';
                        }
                    },
                ]
            });


            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.

            var indonutData = {
                labels: @json($data['labels']),
                datasets: [{
                    data: @json($data['inData']),
                    backgroundColor: @json($data['colors']),
                }]
            }
            var outdonutData = {
                labels: @json($data['labels']),
                datasets: [{
                    data: @json($data['outData']),
                    backgroundColor: @json($data['colors']),
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
                title: {
                    display: true,
                    text: 'PLEASE DISPLAY FOR HEAVEN\'S SAKE'
                },
            }
            var inDonutChart = $('#in-chart').get(0).getContext('2d')
            new Chart(inDonutChart, {
                type: 'doughnut',
                data: indonutData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Income (in)'
                    },
                }
            })
            var outDonutChart = $('#out-chart').get(0).getContext('2d')
            new Chart(outDonutChart, {
                type: 'doughnut',
                data: outdonutData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Expanse (out)'
                    },
                }
            })

        });
    </script>
@endsection
