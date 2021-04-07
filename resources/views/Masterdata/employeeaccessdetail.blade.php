@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Akses Kevin ({{$employee_code}})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item">Akses Karyawan</li>
                    <li class="breadcrumb-item active">Detail Akses</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">

    @php
    $regions = ['MT CENTRAL 1','SUMATERA 1','SUMATERA 2','SUMATERA 3','SUMATERA 4','BANTEN','DKI','JABAR 1','JABAR
    2','R13 JABAR 3','JATENG 1','JATENG 2','JATIM 1','JATIM 2','BALINUSRA','KALIMANTAN','SULAWESI'];
    @endphp
    <div class="row">
        @foreach($regions as $region)
        <div class="col-6 col-md-4">
            <span>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <span class="h5">{{$region}}</span> <input class="form-check-input" type="checkbox" value="checkedValue">
                    </label>
                </div>
            </span>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="location[]" value="location_id" checked>
                    Medan Timur
                </label>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
@section('local-js')
<script>
</script>
@endsection
