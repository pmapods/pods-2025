@if ($armadaticket->status != -1)
@isset($armadaticket->perpanjangan_form)
    @php
        $perpanjanganform = $armadaticket->perpanjangan_form;
    @endphp
    <h5>Form Perpanjangan Perhentian</h5>
    <div class="row border border-dark bg-light p-4">
        <div class="col-12">
            <center class="h4 text-uppercase"><u>form perpanjangan/penghentian sewa armada</u></center>
        </div>
        <div class="col-12 d-flex flex-column mt-5">
            <span>Kami yang bertanda tangan di bawah ini :</span>
            <div class="form-group row mt-2">
                <label class="col-3">Nama</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  {{ $perpanjanganform->nama }}
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3">NIK</label>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $perpanjanganform->nik }}
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3">Jabatan</label>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $perpanjanganform->jabatan }}
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3">Cabang/Depo/CP</label>
                <div class="col-1">:</div>
                <div class="col-8">
                    {{ $perpanjanganform->nama_salespoint }}
                </div>
            </div>
            <span>Dengan ini mengajukan perpanjangan / penghentian sewa armada sebagai berikut :</span>
            <div class="form-group row mt-2">
                <div class="col-1">1.</div>
                <div class="col-2">Armada</div>
                <div class="col-1">:</div>
                <div class="col-7">
                    @switch($perpanjanganform->tipe_armada)
                        @case('niaga')
                            Niaga
                            @break
                        @case('nonniaga')
                            Non Niaga
                            @break
                    @endswitch
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">2.</div>
                <div class="col-2">Jenis Kendaraan</div>
                <div class="col-1">:</div>
                <div class="col-7">
                    {{ $perpanjanganform->jenis_kendaraan }}
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">3.</div>
                <div class="col-2">Nopol</div>
                <div class="col-1">:</div>
                <div class="col-7">
                    {{ $perpanjanganform->nopol }}
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">4.</div>
                <div class="col-2">Unit</div>
                <div class="col-1">:</div>
                <div class="col-7">
                    {{ $perpanjanganform->unit }}
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">5.</div>
                <div class="col-2">Vendor</div>
                <div class="col-1">:</div>
                <div class="col-7">
                    {{ $perpanjanganform->nama_vendor }}
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-1">6.</div>
                <div class="col-10">Status</div>
            </div>

            <div class="form-group row mt-2">
                <div class="offset-1 col-2">
                    Perpanjangan
                </div>
                <div class="col-1">:</div>
                <div class="col-2">
                    {{ ($perpanjanganform->perpanjangan_length != null) ? $perpanjanganform->perpanjangan_length : '-'}} Bulan
                </div>
            </div>
            <div class="form-group row mt-2">
                <div class="offset-1 col-2">
                    Stop Sewa
                </div>
                <div class="col-1">:</div>
                <div class="col-5">
                    {{ ($perpanjanganform->stopsewa_date != null) ? $perpanjanganform->stopsewa_date : '-'}}
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            <span class="mr-2">Alasan : </span>
            @switch($perpanjanganform->stopsewa_reason)
                @case('replace')
                    Replace
                    @break
                @case('renewal')
                    Renewal
                    @break
                @case('end')
                    End Kontrak
                    @break
                @default
                    -
                    @break
            @endswitch
        </div>
        <div class="col-12 pt-3">
            Pernyataan ini dibuat dengan sebenar-benarnya, jika ada perubahan kerugian akan dibebankan kepada masing-masing personal.
        </div>
        <div class="col-12 pt-2">
            <table class="table table-bordered authorization_table">
                <tbody>
                    @php
                        $count = $perpanjanganform->authorizations->count();
                        $headers_name = [];
                        $headers_colspan = [];
                        foreach($perpanjanganform->authorizations as $authorization){
                            array_push($headers_name, $authorization->as);
                            array_push($headers_colspan, 1);
                            $last = $headers_name[count($headers_name)-1];
                            $before_last = $headers_name[count($headers_name)-2] ?? null;
                            // skip check first array
                            if($before_last == null){
                                continue;
                            }
                            if($last == $before_last){
                                array_pop($headers_name);
                                array_pop($headers_colspan);
                                $headers_colspan[count($headers_colspan)-1] += 1;
                            }
                        }
                    @endphp
                    <tr>
                        @foreach($headers_name as $key => $name)
                            <td class="align-middle small table-secondary" colspan="{{ $headers_colspan[$key] }}">{{ $name }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($perpanjanganform->authorizations as $authorization)
                            <td width="{{ 100/$count }}%" class="align-bottom small" style="height: 80px">
                                @if (($perpanjanganform->current_authorization()->employee_id ?? -1) == $authorization->employee_id)
                                    <span class="text-warning">Pending approval</span><br>
                                @endif
                                @if ($authorization->status == 1)
                                    <span class="text-success">Approved {{ $authorization->updated_at->format('Y-m-d (H:i)') }}</span><br>
                                @endif
                                {{ $authorization->employee_name }}<br>{{ $authorization->employee_position }}
                            </td>
                        @endforeach
                    </tr> 
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            @if (($perpanjanganform->current_authorization()->employee_id ?? '-1') == Auth::user()->id)
                <button type="button" class="btn btn-success" onclick="perpanjanganapprove({{ $perpanjanganform->id }})">Approve</button>
                <button type="button" class="btn btn-danger" onclick="perpanjanganreject({{ $perpanjanganform->id }})">Reject</button>
            @endif
        </div>
    </div>
</form>
@else
<form id="formperpanjangan" method="post" action="/addperpanjanganform">
    @csrf
    <input type="hidden" name="armada_ticket_id" value="{{ $armadaticket->id }}">
    <input type="hidden" name="armada_id" value="{{ $armadaticket->armada_id }}">
    <h5>Form Perpanjangan Perhentian</h5>
    @isset($armadaticket->last_rejected_perpanjangan_form)
        Formulir terakhir yang di reject : {{ $armadaticket->last_rejected_perpanjangan_form->code }}<br>
        Alasan Reject : <span class="text-danger">{{ $armadaticket->last_rejected_perpanjangan_form->termination_reason }}</span>
    @endisset
    <div class="row border border-dark bg-light p-4">
        <div class="col-12">
            <center class="h4 text-uppercase"><u>form perpanjangan/penghentian sewa armada</u></center>
        </div>
        <div class="col-12 d-flex flex-column mt-5">
            <span>Kami yang bertanda tangan di bawah ini :</span>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label required_field">Nama</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama" 
                  name="name"
                  required>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label required_field">NIK</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" 
                  class="form-control form-control-sm" placeholder="Masukkan NIK"
                  name="nik"
                  required>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label required_field">Jabatan</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <select class="form-control form-control-sm select2"
                  name="jabatan" 
                  required>
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($employee_positions as $position)
                        <option value="{{$position->name}}">{{$position->name }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label required_field">Cabang/Depo/CP</label>
                <div class="col-1">:</div>
                <div class="col-8">
                    <input type="text" 
                    class="form-control form-control-sm"
                    value="{{ $armadaticket->salespoint->name }}" 
                    name="salespoint_name"
                    readonly>
                    <input type="hidden" name="salespoint_id" value="{{ $armadaticket->salespoint->id }}">
                </div>
            </div>
            <span>Dengan ini mengajukan perpanjangan / penghentian sewa armada sebagai berikut :</span>
            <div class="form-group row mt-2">
                <div class="col-1">1.</div>
                <div class="col-2 small required_field">Armada</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                  <input type="text" 
                  class="form-control form-control-sm" 
                  value="{{ ($armadaticket->isNiaga)?'niaga':'nonniaga' }}"
                  name="armada_type" 
                  readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">2.</div>
                <div class="col-2 small required_field">Jenis Kendaraan</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" value="{{ $armadaticket->armada_type()->name }}" 
                    name="jenis_kendaraan"
                    readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">3.</div>
                <div class="col-2 small required_field">Nopol</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" value="{{ $armadaticket->armada()->plate }}" 
                    name="nopol"
                    readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">4.</div>
                <div class="col-2 small required_field">Unit</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <select class="form-control form-control-sm" 
                    name="unit"
                    required>
                        <option value="">-- Pilih Unit --</option>
                        <option value="GS">GS</option>
                        <option value="GT">GT</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">5.</div>
                <div class="col-2 small required_field">Vendor</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <select class="form-control form-control-sm vendor" 
                    name="vendor_name"
                    required>
                        <option value="">-- Pilih Unit --</option>
                        <option value="ASSA">ASSA</option>
                        <option value="Batavia">Batavia</option>
                        <option value="TRAC">TRAC</option>
                        <option value="Mardika">Mardika</option>
                        <option value="MPM">MPM</option>
                        <option value="lokal">Lokal</option>
                    </select>
                    <input type="text" class="form-control form-control-sm mt-1 localvendor"
                    placeholder="Masukkan Nama Vendor Lokal"
                    name="lokal_vendor_name"
                    disabled>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-1 small">6.</div>
                <div class="col-10 small">Status</div>
            </div>

            <div class="form-group row mt-2">
                <div class="offset-1 col-2 small">
                    <input type="radio" name="form_type" id="perpanjangan_radio" value="perpanjangan" required>
                    <label for="perpanjangan_radio">Perpanjangan</label>
                </div>
                <div class="col-1 small">:</div>
                <div class="col-2">
                    <div class="input-group input-group-sm">
                        <input type="number" class="form-control" 
                        min="1"
                        name="perpanjangan_length"
                        id="perpanjangan_length"
                        disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                    </div>
                </div>
                <div class="col-5">(diisi berapa bulan akan diperpanjang)</div>
            </div>
            <div class="form-group row mt-2">
                <div class="offset-1 col-2 small">
                    <input type="radio" name="form_type" id="stopsewa_radio" value="stopsewa">
                    <label for="stopsewa_radio">Stop Sewa</label>
                </div>
                <div class="col-1">:</div>
                <div class="col-5">
                    <input type="date" 
                    class="form-control form-control-sm"
                    name="stopsewa_date"
                    id="stopsewa_date"
                    disabled>
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            <span class="required_field mr-2">Alasan</span>

            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="alasan" 
                    value="replace"
                    id="replace_radio"
                    disabled>Replace
                </label>
            </div>
            
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="alasan" 
                    value="renewal" 
                    id="renewal_radio"
                    disabled>Renewal
                </label>
            </div>
            
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="alasan" 
                    value="end"
                    id="end_radio"
                    disabled>End Kontrak
                </label>
            </div>
        </div>
        <div class="col-12 pt-3">
            Pernyataan ini dibuat dengan sebenar-benarnya, jika ada perubahan kerugian akan dibebankan kepada masing-masing personal.
        </div>
        <div class="col-12 pt-2">
            <div class="form-group">
              <label class="required_field">Pilih Otorisasi</label>
              <select class="form-control authorization"
              name="authorization_id" required>
                  <option value="">-- Pilih Otorisasi --</option>
                  @foreach ($formperpanjangan_authorizations as $authorization)
                    @php
                    $list= $authorization->authorization_detail;
                    $string = "";
                    foreach ($list as $key=>$author){
                        $author->employee_position->name;
                        $string = $string.$author->employee->name;
                        if(count($list)-1 != $key){
                            $string = $string.' -> ';
                        }
                    }
                    @endphp
                    <option value="{{ $authorization->id }}"
                        data-list = "{{ $list }}">
                        {{$string}}</option>
                  @endforeach
              </select>
            </div>
        </div>
        <div class="col-12 pt-2">
            <table class="table table-bordered authorization_table">
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endisset
@endif
@section('perpanjangan-js')
{{-- form perpanjangan perhentian --}}
<script>
    let formperpanjangan = $('#formperpanjangan');
    $(document).ready(function () {
        formperpanjangan.find('.vendor').change(function(){
            formperpanjangan.find('.localvendor').val('');
            if($(this).val() == 'lokal'){
                formperpanjangan.find('.localvendor').prop('disabled',false);
                formperpanjangan.find('.localvendor').prop('required',true);
            }else{
                formperpanjangan.find('.localvendor').prop('disabled',true);
                formperpanjangan.find('.localvendor').prop('required',false);
            }
        });

        formperpanjangan.find('.authorization').change(function(){
            let list = $(this).find('option:selected').data('list');
            if(list == null){
                formperpanjangan.find('.authorization_table').hide();
                return;
            }
            formperpanjangan.find('.authorization_table').show();
            let table_string = '<tr>';
            let temp = '';
            let col_count = 1;
            // authorization header
            list.forEach((item,index)=>{
                if(index > 0){
                    if(temp == item.sign_as){
                        col_count++;
                    }else{
                        table_string += '<td class="small" colspan="'+col_count+'">'+temp+'</td>';
                        temp = item.sign_as;
                        col_count =1;
                    }
                }else{  
                    temp = item.sign_as;
                }
                if(index == list.length-1){
                    table_string += '<td class="small" colspan="'+col_count+'">'+temp+'</td>';
                }
            });
            table_string += '</tr><tr>';
            list.forEach((item,index)=>{
                table_string += '<td width="20%" class="align-bottom small" style="height: 80px"><b>'+item.employee.name+'</b><br>'+item.employee_position.name+'</td>';
            });
            table_string += '</tr>';

            formperpanjangan.find('.authorization_table tbody').empty();
            formperpanjangan.find('.authorization_table tbody').append(table_string);
        });

        $('input[type=radio][name=form_type]').on('change', function() {
            $('#stopsewa_date').val("");
            $('#perpanjangan_length').val("");
            $('#replace_radio').prop('checked', false);
            $('#renewal_radio').prop('checked', false);
            $('#end_radio').prop('checked', false);

            $('#stopsewa_date').prop('disabled',true);
            $('#stopsewa_date').prop('required',false);
            $('#perpanjangan_length').prop('disabled',true);
            $('#perpanjangan_length').prop('required',false);

            $('#replace_radio').prop('disabled',true);
            $('#renewal_radio').prop('disabled',true);
            $('#end_radio').prop('disabled',true);
            $('#replace_radio').prop('required',false);
            
            switch ($(this).val()) {
                case 'perpanjangan':
                    $('#perpanjangan_length').prop('disabled',false);
                    $('#perpanjangan_length').prop('required',true);
                    break;
                case 'stopsewa':
                    $('#stopsewa_date').prop('disabled',false);
                    $('#stopsewa_date').prop('required',true);
                    $('#replace_radio').prop('disabled',false);
                    $('#renewal_radio').prop('disabled',false);
                    $('#end_radio').prop('disabled',false);
                    $('#replace_radio').prop('required',true);
                    break;
            }
        });
    });
    function perpanjanganapprove(perpanjangan_form_id){
        $('#submitform').prop('action', '/approveperpanjanganform');
        $('#submitform').prop('method', 'POST');
        $('#submitform').find('div').append('<input type="hidden" name="perpanjangan_form_id" value="'+perpanjangan_form_id+'">');
        $('#submitform').submit();
    }
    function perpanjanganreject(perpanjangan_form_id){
        var reason = prompt("Harap memasukan alasan reject formulir");
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return;
            }
            $('#submitform').prop('action', '/rejectperpanjanganform');
            $('#submitform').prop('method', 'POST');
            $('#submitform').find('div').append('<input type="hidden" name="perpanjangan_form_id" value="'+perpanjangan_form_id+'">');
            $('#submitform').find('div').append('<input type="hidden" name="reason" value="'+reason+'">');
            $('#submitform').submit();
        }
    }
</script>
@endsection