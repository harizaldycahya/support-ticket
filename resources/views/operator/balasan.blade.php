@extends('layouts.app')

@section('content')
    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        @include('inc.operator.balasan_sidebar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                
                <!-- Top Bar Start -->
                @include('inc.operator.navbar')
                <!-- Top Bar End -->
        
                <div class="page-content-wrapper ">

                    <div class="container-fluid">
                        <div style="min-height: 5vh;"></div>

                        <div class="col-xl-12">
                            <p>
                                <!-- <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                  Link with href
                                </a> -->
                                <button class="btn btn-block btn-secondary pt-2 pb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="mdi mdi-pencil"></i> Balas
                                </button>
                              </p>
                              <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <form method="POST" action="{{route('operator.balasan.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Pesan</label>
                                            <textarea name="balasan" class="summernote"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload file</label>
                                            <input type="file" name="files[]" multiple>
                                        </div>
                                        <input name="tiket_id" type="hidden" value="{{$tiket->id}}">
                                        <input name="divisi_id" type="hidden" value="{{$tiket->divisi_id}}">
                                        <div style="min-height:5vh;"></div>
                                        <div class="form-group">
                                            <div>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                              </div>
                        </div>

                        <div class="row p-3">
                            <div class="col-lg-12">
                                @foreach ($balasans as $balasan)
                                    <div class="card m-b-30">
                                        @switch($balasan->role_id)
                                            @case(1)
                                            <div class="card-header bg-info text-white mb-3">
                                                <div class="row">
                                                    <div class="col-xl-9">
                                                        <i class="mdi mdi-account-outline"></i> 
                                                        Admin
                                                        | {{$balasan->user_name}} {{$balasan->client_name}}
                                                    </div>    
                                                    <div class="col-xl-3">
                                                        <i class="mdi mdi-calendar-clock"></i> {{$balasan->created_at}}
                                                    </div>
                                                </div>
                                            </div>
                                                @break
                                            @case(2)
                                            <div class="card-header bg-primary text-white mb-3">
                                                <div class="row">
                                                    <div class="col-xl-9">
                                                        <i class="mdi mdi-account-outline"></i> 
                                                        Operator
                                                        | {{$balasan->user_name}} {{$balasan->client_name}}
                                                    </div>    
                                                    <div class="col-xl-3">
                                                        <i class="mdi mdi-calendar-clock"></i> {{$balasan->created_at}}
                                                    </div>
                                                </div>
                                            </div>
                                                @break
                                            @default
                                            <div class="card-header bg-secondary text-white mb-3">
                                                <div class="row">
                                                    <div class="col-xl-9">
                                                        <i class="mdi mdi-account-outline"></i> 
                                                        Client
                                                        | {{$balasan->user_name}} {{$balasan->client_name}}
                                                    </div>    
                                                    <div class="col-xl-3">
                                                        <i class="mdi mdi-calendar-clock"></i> {{$balasan->created_at}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endswitch
                                        <div class="card-body">
                                            <p class="card-text">
                                                {!! $balasan->balasan !!}
                                            </p>
                                            <div class="col-md-12 p-0 text-left">
                                                <hr>
                                                @switch($balasan->role_id)
                                                    @case(1)
                                                    <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#balasan_file_{{$balasan->id}}" aria-expanded="false" aria-controls="balasan_file">
                                                        File pendukung <i class="mdi mdi-arrow-down"></i>
                                                    </button>
                                                        @break
                                                    @case(2)
                                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#balasan_file_{{$balasan->id}}" aria-expanded="false" aria-controls="balasan_file">
                                                        File pendukung <i class="mdi mdi-arrow-down"></i>
                                                    </button>
                                                        @break
                                                    @default
                                                    <button class="btn btn-sm btn-secondary" type="button" data-toggle="collapse" data-target="#balasan_file_{{$balasan->id}}" aria-expanded="false" aria-controls="balasan_file">
                                                        File pendukung <i class="mdi mdi-arrow-down"></i>
                                                    </button>
                                                @endswitch
                                                <div class="collapse bg-light p-3" id="balasan_file_{{$balasan->id}}">
                                                    @if ($balasan_file_array != null)
                                                        @foreach ($balasan_file_array[$loop->index] as $balasan_file)
                                                            <div>
                                                                @if ($balasan_file != '')
                                                                <form action="{{route('operator.balasan.file_download')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="balasan_file" value="{{$balasan_file}}">
                                                                    <button type="submit" class="btn btn-info btn-sm mt-1" data-toggle="tooltip" data-placement="top" title="Download File"> 
                                                                        <i class="mdi mdi-arrow-down"></i> {{$balasan_file}}
                                                                    </button>
                                                                    <br>
                                                                </form> 
                                                                @else
                                                                Tidak ada file 
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                @endforeach

                                <div class="card m-b-30">
                                    @switch($tiket->role_id)
                                        @case(1)
                                        <div class="card-header bg-info text-white mb-3">
                                            <div class="row">
                                                <div class="col-xl-9">
                                                    <i class="mdi mdi-account-outline"></i> 
                                                    Admin
                                                    | {{$tiket->client_name}} {{$tiket->user_name}}
                                                </div>    
                                                <div class="col-xl-3">
                                                    <i class="mdi mdi-calendar-clock"></i> {{$tiket->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                            @break
                                        @case(2)
                                        <div class="card-header bg-primary text-white mb-3">
                                            <div class="row">
                                                <div class="col-xl-9">
                                                    <i class="mdi mdi-account-outline"></i> 
                                                    Operator
                                                    | {{$tiket->client_name}} {{$tiket->user_name}}
                                                </div>    
                                                <div class="col-xl-3">
                                                    <i class="mdi mdi-calendar-clock"></i> {{$tiket->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                            @break
                                        @default
                                        <div class="card-header bg-secondary text-white mb-3">
                                            <div class="row">
                                                <div class="col-xl-9">
                                                    <i class="mdi mdi-account-outline"></i> 
                                                    Client
                                                    | {{$tiket->client_name}} {{$tiket->user_name}}
                                                </div>    
                                                <div class="col-xl-3">
                                                    <i class="mdi mdi-calendar-clock"></i> {{$tiket->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                    @endswitch
                                    <div class="card-body">
                                        <p class="card-text">
                                            {!! $tiket->ket !!}
                                        </p>
                                        <div class="col-md-12 p-0 text-left">
                                            <hr>
                                            @switch($tiket->role_id)
                                                @case(1)
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#tiket_file" aria-expanded="false" aria-controls="balasan_file">
                                                    File pendukung <i class="mdi mdi-arrow-down"></i>
                                                </button>
                                                    @break
                                                @case(2)
                                                <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#tiket_file" aria-expanded="false" aria-controls="balasan_file">
                                                    File pendukung <i class="mdi mdi-arrow-down"></i>
                                                </button>
                                                    @break
                                                @default
                                                <button class="btn btn-sm btn-secondary" type="button" data-toggle="collapse" data-target="#tiket_file" aria-expanded="false" aria-controls="balasan_file">
                                                    File pendukung <i class="mdi mdi-arrow-down"></i>
                                                </button>
                                            @endswitch
                                            <div class="collapse bg-light p-3" id="tiket_file">
                                                @if ($tiket_files != null)
                                                    @foreach ($tiket_files as $tiket_file)
                                                        <form action="{{route('operator.tiket.file_download')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="file" value="{{$tiket_file}}">
                                                            <button type="submit" class="btn btn-info btn-sm mt-1" data-toggle="tooltip" data-placement="top" title="Download File"> 
                                                                <i class="mdi mdi-arrow-down"></i> {{$tiket_file}}
                                                            </button>
                                                            <br>
                                                        </form>
                                                    @endforeach
                                                @else
                                                <div>Tidak ada file</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                
                            </div> <!-- end col -->
                        </div> <!-- end row -->  

                    </div><!-- container fluid -->

                </div> <!-- Page content Wrapper -->
        
            </div> <!-- content -->
        
        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->
@endsection
