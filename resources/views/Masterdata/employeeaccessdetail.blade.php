@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Akses {{$employee->name}} ({{$employee->code}})</h1>
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
        $checkedlist = $employee->location_access->pluck('salespoint_id');
    @endphp
    <form action="/updateemployeeaccessdetail" method="post">
        @csrf
        @method('patch')
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        <h3>Akses Area</h3>
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
                        <input type="checkbox" class="form-check-input salespoint_check" name="location[]" value="{{$salespoint->id}}"
                        @if($checkedlist->contains($salespoint->id)) checked @endif>
                        {{$salespoint->name}} ({{$salespoint->status_name()}} - {{$salespoint->trade_type_name()}})
                    </label>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        <hr>
        <h3>Akses Menu</h3>
        <div class="row">
            <div class="col-6 col-md-4 mb-3">
                <div class="form-check form-check-inline mb-2">
                    <label class="form-check-label">
                        <span class="h4 mr-2">Master Data</span> <input class="form-check-input" type="checkbox">
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Jabatan
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Karyawan
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Salespoint
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Akses Karyawan
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Matriks Otorisasi
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Vendor
                    </label>
                </div>
            </div>
            
            <div class="col-6 col-md-4 mb-3">
                <div class="form-check form-check-inline mb-2">
                    <label class="form-check-label">
                        <span class="h4 mr-2">Operational</span> <input class="form-check-input" type="checkbox">
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Pengadaan
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Bidding
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">Purchase Requisition
                    </label>
                </div>
            </div>
        </div>
    
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary btn-lg">Perbarui Hak Akses</button>
        </div>
    </form>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
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
        });
        
        // check setiap region
        $('.location_check').each((location_index,location_element)=>{
            let region_check = $(location_element).find('.region_check');
            let salespoints = $(location_element).find('.salespoint_check');
            let checked = 0;
            let unchecked = 0;
            salespoints.each(function(salespoint_index,salespoint_element){
                let isChecked = $(salespoint_element).prop('checked');
                if(isChecked){
                    checked++;
                }else{
                    unchecked++;
                }
            })
            if(checked>unchecked){
                region_check.prop('indeterminate',false);
                region_check.prop('checked',true);
            }else{
                region_check.prop('indeterminate',false);
                region_check.prop('checked',false);
            }

            if(checked>0 && unchecked>0){
                region_check.prop('indeterminate',true);
            }

        });
    })
</script>
@endsection
