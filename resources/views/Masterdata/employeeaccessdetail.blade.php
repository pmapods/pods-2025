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
    <div class="row">
        @foreach($regions as $key => $region)
        <div class="col-6 col-md-4 mb-3 location_check">
            <div class="form-check form-check-inline mb-2">
                <label class="form-check-label">
                    <span class="h4 mr-2">{{$region->first()->region_name()}}</span> <input class="form-check-input region_check" type="checkbox" value="{{$region->first()->region}}">
                </label>
            </div>
            @foreach($region as $salespoint)
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input salespoint_check" name="location[]" value="location_id">
                    {{$salespoint->name}} ({{$salespoint->status_name()}} - {{$salespoint->trade_type_name()}})
                </label>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="text-center mt-3">
        <button type="button" class="btn btn-primary btn-lg">Perbarui Hak Akses</button>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        // location_check
        // region_check
        // salespoint_check
        $('.region_check').on('change', function(){
            let parent = $(this).closest('.location_check');
            let isChecked = $(this).prop('checked');
            if(isChecked){
                parent.find('.salespoint_check').prop('checked', true);
            }else{
                parent.find('.salespoint_check').prop('checked', false);
            }
        });
        $('.location_check').on('change', function(){
            let parent = $(this).closest('.location_check');
            let isChecked = $(this).prop('checked');
            let checked_count = 0;
            let unchecked_count = 0;
            parent.find('.salespoint_check').each(function(){
                if($(this).prop('checked')){
                    checked_count++;
                }else{
                    unchecked_count++;
                }
            });

            if(checked_count>unchecked_count){
                parent.find('.region_check').prop('indeterminate',false);
                parent.find('.region_check').prop('checked',true);
            }else{
                parent.find('.region_check').prop('indeterminate',false);
                parent.find('.region_check').prop('checked',false);
            }

            if(checked_count>0 && unchecked_count>0){
                parent.find('.region_check').prop('indeterminate',true);
            }

        })
    })
</script>
@endsection
