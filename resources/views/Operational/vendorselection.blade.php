@extends('Layout.app')

@section('local-css')
<style>
    #form_table thead{
        background-color: #76933C;
        border : 1px solid #000 !important;
    }
    #form_table td, #form_table th{
        vertical-align: middle !important;
    }
    textarea{
        resize:none !important;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Form Seleksi Vendor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Bidding</li>
                    <li class="breadcrumb-item">{{$ticket->code}}</li>
                    <li class="breadcrumb-item active">{{$ticket_item->name}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@php
    if(isset($bidding)){
        foreach ($bidding->bidding_detail as $key=>$detail){
            $address[$key] = $detail->address;
            $start_harga[$key] = $detail->start_harga;
            $end_harga[$key] = $detail->end_harga;
            $price_score[$key] = $detail->price_score;
            $start_ppn[$key] = $detail->start_ppn;
            $end_ppn[$key] = $detail->end_ppn;
            $start_ongkir_price[$key] = $detail->start_ongkir_price;
            $end_ongkir_price[$key] = $detail->end_ongkir_price;
            $start_pasang_price[$key] = $detail->start_pasang_price;
            $end_pasang_price[$key] = $detail->end_pasang_price;
            $spesifikasi[$key] = $detail->spesifikasi;
            $ketersediaan_barang_score[$key] = $detail->ketersediaan_barang_score;
            $ready[$key] = $detail->ready;
            $indent[$key] = $detail->indent;
            $garansi[$key] = $detail->garansi;
            $bonus[$key] = $detail->bonus;
            $creditcash[$key]= $detail->creditcash;
            $ketentuan_bayar_score[$key]= $detail->ketentuan_bayar_score;
            $menerbitkan_faktur_pajak[$key]= $detail->menerbitkan_faktur_pajak;
            $masa_berlaku_penawaran[$key]= $detail->masa_berlaku_penawaran;
            $others_score[$key]= $detail->others_score;
            $start_lama_pengerjaan[$key]= $detail->start_lama_pengerjaan;
            $end_lama_pengerjaan[$key]= $detail->end_lama_pengerjaan;
            $optional1_start[$key]= $detail->optional1_start;
            $optional1_end[$key]= $detail->optional1_end;
            $optional2_start[$key]= $detail->optional2_start;
            $optional2_end[$key]= $detail->optional2_end;
        }
        $price_notes = $bidding->price_notes;
        $ketersediaan_barang_notes = $bidding->ketersediaan_barang_notes;
        $ketentuan_bayar_notes = $bidding->ketentuan_bayar_notes;
        $keterangan_lain= $bidding->keterangan_lain;
        $optional1_name= $bidding->optional1_name;
        $optional2_name= $bidding->optional2_name;
    }
@endphp
<div class="content-body px-4">
    <form action="/addbiddingform" method="post">
        @csrf
        <input type="hidden" name="ticket_item_id" value="{{$ticket_item->id}}">
        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
        <div class="row">
            <div class="col-md-2 mt-3">Jenis Produk</div>
            <div class="col-md-4 mt-3">
                <input type="text" class="form-control" value="{{$ticket_item->name}}" readonly>
            </div>

            <div class="col-md-2 mt-3">Area / Salespoint</div>
            <div class="col-md-4 mt-3">
                <input type="text" class="form-control" value="{{$ticket->salespoint->name}}" readonly>
            </div>

            <div class="col-md-2 mt-3">Tanggal Seleksi</div>
            <div class="col-md-4 mt-3">
                <input type="text" class="form-control" value="{{now()->translatedFormat('d F Y')}}" readonly>
            </div>

            <div class="col-md-2 mt-3">Kelompok</div>
            <div class="col-md-4 mt-3">
                <div class="form-group">
                    <select class="form-control" id="select_kelompok" name="group">
                        <option value="asset">Asset</option>
                        <option value="inventory">Inventaris</option>
                        <option value="others">Lain-Lain</option>
                    </select>
                    <input type="text" class="form-control mt-2" name="others_name" placeholder="isi nama Kelompok Lain"
                        id="input_kelompok_lain" style="display: none">
                </div>
            </div>
        </div>
        @php
        $vendors = $ticket->ticket_vendor;
        @endphp
        @foreach ($vendors as $key=>$vendor)
        <input type="hidden" name="vendor[{{$key}}][ticket_vendor_id]" value="{{$vendor->id}}">
        @endforeach
        <table class="table table-bordered" id="form_table">
            <thead>
                <tr>
                    <th class="text-center" rowspan="5" class="text-center">No</th>
                    <th class="text-center" rowspan="5" class="text-center">Penilaian</th>
                    <th class="text-center" rowspan="5" class="text-center">Bobot</th>
                    @for($i=0; $i<2; $i++) <th colspan="3" class="text-center" id="vendor_name_{{$i}}">
                        {{($vendors->get($i)) ? $vendors->get($i)->name : '-'}}
                        </th>
                        @endfor
                        <th class="text-center" rowspan="5" class="text-center">Keterangan</th>
                </tr>
                <tr>
                    @for($i=0; $i<2; $i++) <th>Alamat</th>
                        <th colspan="2">
                            @if ($vendors->get($i))
                            @if ($vendors->get($i)->type == 0)
                            {{$vendors->get($i)->vendor()->address}}
                            @else
                            <textarea class="form-control" name="vendor[{{$i}}][address]"
                                rows="3">{{$address[$i] ?? '-'}}</textarea>
                            @endif
                            @else
                            -
                            @endif
                        </th>
                        @endfor
                </tr>
                <tr>
                    @for($i=0; $i<2; $i++) <th>PIC</th>
                        <th colspan="2">
                            @if ($vendors->get($i))
                            {{$vendors->get($i)->salesperson}}
                            @else
                            -
                            @endif
                        </th>
                        @endfor
                </tr>
                <tr>
                    @for($i=0; $i<2; $i++) <th>Telp/HP</th>
                        <th colspan="2">
                            @if ($vendors->get($i))
                            @if ($vendors->get($i)->type == 0)
                            {{$vendors->get($i)->vendor()->phone}}
                            @else
                            {{$vendors->get($i)->phone}}
                            @endif
                            @else
                            -
                            @endif
                        </th>
                        @endfor
                </tr>
                <tr>
                    <th>Proposal Awal</th>
                    <th>Proposal Akhir</th>
                    <th width="80">Nilai</th>
                    <th>Proposal Awal</th>
                    <th>Proposal Akhir</th>
                    <th width="80">Nilai</th>
                </tr>
            </thead>
            <tbody>
                {{-- price --}}
                <tr class="table-success">
                    <td colspan="10"><b>Price</b></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Harga</td>
                    <td class="text-center" rowspan="4">5</td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <input type="text" class="form-control rupiah" name="vendor[{{$i}}][harga_awal]"
                            value="{{$start_harga[$i] ?? 0}}">
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <input type="text" class="form-control rupiah" name="vendor[{{$i}}][harga_akhir]"
                                value="{{$end_harga[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        <td class="text-center" rowspan="4">
                            @if($vendors->get($i))
                            <input type="number" class="form-control nilai" min="0" max="5"
                                name="vendor[{{$i}}][nilai_harga]" id="nilai_harga_{{$i}}"
                                value="{{$price_score[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                        <td class="text-center" rowspan="4">
                            <textarea class="form-control" name="keterangan_harga"
                                rows="10">{{$price_notes ?? '-'}}</textarea>
                        </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>PPN</td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <input type="text" class="form-control rupiah" name="vendor[{{$i}}][ppn_awal]"
                            value="{{$start_ppn[$i] ?? 0}}">
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <input type="text" class="form-control rupiah" name="vendor[{{$i}}][ppn_akhir]"
                                value="{{$end_ppn[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>3</td>
                    <td>Ongkos Kirim</td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <input type="text" class="form-control rupiah" name="vendor[{{$i}}][send_fee_awal]"
                            value="{{$start_ongkir_price[$i] ?? 0}}">
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <input type="text" class="form-control rupiah" name="vendor[{{$i}}][send_fee_akhir]"
                                value="{{$end_ongkir_price[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>4</td>
                    <td>Ongkos Pasang</td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <input type="text" class="form-control rupiah" name="vendor[{{$i}}][apply_fee_awal]"
                            value="{{$start_pasang_price[$i] ?? 0}}">
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <input type="text" class="form-control rupiah" name="vendor[{{$i}}][apply_fee_akhir]"
                                value="{{$end_pasang_price[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                </tr>

                {{-- Ketersediaan  Barang --}}
                <tr class="table-success">
                    <td colspan="10"><b>Ketersediaan Barang</b></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Spesifikasi (merk/type)</td>
                    <td class="text-center" rowspan="5">3</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][specs]"
                            value="{{$spesifikasi[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        <td class="text-center" rowspan="5">
                            @if($vendors->get($i))
                            <input type="number" class="form-control nilai" min="0" max="3"
                                name="vendor[{{$i}}][nilai_ketersediaan]" id="nilai_ketersediaan_{{$i}}"
                                value="{{$ketersediaan_barang_score[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                        <td class="text-center" rowspan="5">
                            <textarea class="form-control" name="keterangan_ketersediaan"
                                rows="12">{{$ketersediaan_barang_notes ?? '-'}}</textarea>
                        </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Ready</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][ready]"
                            value="{{$ready[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>7</td>
                    <td>Indent</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][indent]"
                            value="{{$indent[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>8</td>
                    <td>Barang bergaransi</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][garansi]"
                            value="{{$garansi[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td>9</td>
                    <td>Bonus</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][bonus]"
                            value="{{$bonus[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        @endfor
                </tr>

                {{-- Ketentuan Pembayaran --}}
                <tr class="table-success">
                    <td colspan="10"><b>Ketentuan Pembayaran</b></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Credit / Cash</td>
                    <td class="text-center" rowspan="2">2</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <select class="form-control" name="vendor[{{$i}}][cc]">
                            <option @if($creditcash[$i] ?? ''=='credit' ) selected @endif value="credit">Credit</option>
                            <option @if($creditcash[$i] ?? ''=='cash' ) selected @endif value="cash">Cash</option>
                        </select>
                        @else
                        -
                        @endif
                        </td>
                        <td class="text-center" rowspan="2">
                            @if($vendors->get($i))
                            <input type="number" class="form-control nilai" min="0" max="2"
                                name="vendor[{{$i}}][nilai_pembayaran]" id="nilai_pembayaran_{{$i}}"
                                value="{{$ketentuan_bayar_score[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                        <td class="text-center" rowspan="2">
                            <textarea class="form-control" rows="5"
                                name="keterangan_pembayaran">{{$ketentuan_bayar_notes ?? '-'}}</textarea>
                        </td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Menerbitkan Faktur Pajak</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <select class="form-control" name="vendor[{{$i}}][pajak]">
                            <option @if($menerbitkan_faktur_pajak[$i] ?? -1==0) selected @endif value="0">Tidak</option>
                            <option @if($menerbitkan_faktur_pajak[$i] ?? -1==0) selected @endif value="1">Ya</option>
                        </select>
                        @else
                        -
                        @endif
                        </td>
                        @endfor
                </tr>

                {{-- Informasi lain-Lain --}}
                <tr class="table-success">
                    <td colspan="10"><b>Informasi Lain-lain</b></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Masa berlaku penawaran</td>
                    <td class="text-center" rowspan="4">2</td>
                    @for ($i=0; $i<2; $i++) <td colspan="2">
                        @if($vendors->get($i))
                        <div class="input-group">
                            <input type="number" class="form-control" min="0" name="vendor[{{$i}}][period]"
                                value="{{$masa_berlaku_penawaran[$i] ?? 0}}">
                            <span class="input-group-text">Hari</span>
                        </div>
                        @else
                        -
                        @endif
                        </td>
                        <td class="text-center" rowspan="4">
                            @if($vendors->get($i))
                            <input type="number" class="form-control nilai" min="0" max="2"
                                name="vendor[{{$i}}][nilai_other]" id="nilai_other_{{$i}}"
                                value="{{$others_score[$i] ?? 0}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                        <td class="text-center" rowspan="4">
                            <textarea class="form-control" rows="10"
                                name="keterangan_lain">{{$keterangan_lain ?? '-'}}</textarea>
                        </td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>Lama Pengerjaan</td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <div class="input-group">
                            <input type="number" class="form-control" min="0" name="vendor[{{$i}}][time_awal]"
                                value="{{$start_lama_pengerjaan[$i] ?? 0}}">
                            <span class="input-group-text">Hari</span>
                        </div>
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <div class="input-group">
                                <input type="number" class="form-control" min="0" name="vendor[{{$i}}][time_akhir]"
                                    value="{{$end_lama_pengerjaan[$i] ?? 0}}">
                                <span class="input-group-text">Hari</span>
                            </div>
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                </tr>

                <tr>
                    <td>14</td>
                    <td>
                        <input type="text" class="form-control" name="optional1_name"
                            value="{{$optional1_name ?? '-'}}">
                    </td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][optional1_awal]"
                            value="{{$optional1_start[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <input type="text" class="form-control" name="vendor[{{$i}}][optional1_akhir]"
                                value="{{$optional1_end[$i] ?? '-'}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                </tr>

                <tr>
                    <td>15</td>
                    <td>
                        <input type="text" class="form-control" name="optional2_name"
                            value="{{$optional2_name ?? '-'}}">
                    </td>
                    @for ($i=0; $i<2; $i++) <td>
                        @if($vendors->get($i))
                        <input type="text" class="form-control" name="vendor[{{$i}}][optional2_awal]"
                            value="{{$optional2_start[$i] ?? '-'}}">
                        @else
                        -
                        @endif
                        </td>
                        <td>
                            @if($vendors->get($i))
                            <input type="text" class="form-control" name="vendor[{{$i}}][optional2_akhir]"
                                value="{{$optional2_end[$i] ?? '-'}}">
                            @else
                            -
                            @endif
                        </td>
                        @endfor
                </tr>
                <tr>
                    <td class="empty_column" colspan="3"></td>
                    <td colspan="2" class="table-success">Total Nilai</td>
                    <td id="total_0">0</td>
                    <td colspan="2" class="table-success">Total Nilai</td>
                    <td id="total_1">0</td>
                </tr>
            </tbody>
        </table>
        <center>
            <h5>Rekomendasi Vendor Terpilih</h5>
            <h4 id="selected_vendor">-</h4>
        </center>
        <b>CATATAN</b><br>
        <ol>
            <li>VENDOR YANG DINYATAKAN LULUS ADALAH JIKA NILAI > 30</li>
            <li>SELEKSI VENDOR DIIKUTI OLEH MINIMAL 2 VENDOR SEJENIS</li>
            <li>VENDOR YANG DIPILIH ADALAH 1 VENDOR YANG LULUS SELEKSI DENGAN NILAI PALING TINGGI</li>
        </ol>

        <div class="form-group">
            <label class="required_field">Pilih Otorisasi</label>
            <select class="form-control" name="authorization_id" required>
                <option value="">-- Pilih Otorisasi --</option>
                @foreach ($authorizations as $authorization)
                @php
                $list= $authorization->authorization_detail;
                $string = "";
                foreach ($list as $key=>$author){
                $string = $string.$author->employee->name;
                if(count($list)-1 != $key){
                $string = $string.' -> ';
                }
                }
                @endphp
                <option value="{{ $authorization->id }}">{{$string}}</option>
                @endforeach
            </select>
        </div>
        <b>ATTACHMENT</b><br>
            @if($ticket_item->ticket_item_attachment->count() > 0 || $ticket_item->ticket_item_file_requirement->count() > 0)
                @if ($ticket_item->ticket_item_attachment->count() > 0)
                <table class="table table-borderless table-sm">
                    <tbody>
                        @foreach ($bidding->ticket_item->ticket_item_attachment as $attachment)
                        <tr>
                            @php
                            $naming = "";
                            $filename = explode('.',$attachment->name)[0];
                            switch ($filename) {
                            case 'ba_file':
                            $naming = "berita acara merk/tipe lain";
                            break;

                            case 'old_item':
                            $naming = "foto barang lama untuk replace";
                            break;

                            default:
                            $naming = $filename;
                            break;
                            }
                            @endphp
                            <td width="40%">{{$naming}}</td>
                            <td width="60%" class="tdbreak"><a href="/storage{{$attachment->path}}"
                                    download="{{$attachment->name}}">tampilkan attachment</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if ($ticket_item->ticket_item_file_requirement->count() > 0)
                <table class="table table-borderless table-sm">
                    <tbody>
                        @foreach ($item->ticket_item_file_requirement as $requirement)
                        <tr>
                            <td width="40%">{{$requirement->file_completement->name}}</td>
                            <td width="60%" class="tdbreak"><a href="/storage{{$requirement->path}}"
                                    download="{{$requirement->name}}">tampilkan attachment</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            @else
            -
            @endif
        <center>
            <button type="submit" class="btn btn-primary">Buat Form Bidding</button>
        </center>
    </form>
</div>

@endsection
@section('local-js')
<script>
    var isSelected = false;
    $(document).on('click', 'form button[type=submit]', function(e) {
        if(!isSelected) {
            alert('Harus terpilih satu vendor');
            e.preventDefault(); //prevent the default action
        }
    });
    $(document).ready(function() {
        $('input[type="number"]').change(function(){
            autonumber($(this));
        });

        $('#select_kelompok').change(function(){
            $('#input_kelompok_lain').val("");
            if($(this).val()=='others'){
                $('#input_kelompok_lain').show();
            }else{
                $('#input_kelompok_lain').hide();
            }
        })
        $(this).on('change','.nilai',function() {
            // vendor 1
            let harga = $('#nilai_harga_0').val()*5;
            let ketersediaan = $('#nilai_ketersediaan_0').val()*3;
            let pembayaran = $('#nilai_pembayaran_0').val()*2;
            let other = $('#nilai_other_0').val()*2;
            let total_0 = parseInt(harga) + parseInt(ketersediaan) + parseInt(pembayaran) + parseInt(other);
            $('#total_0').text(total_0);

            // vendor 2
            harga = $('#nilai_harga_1').val()*5;
            ketersediaan = $('#nilai_ketersediaan_1').val()*3;
            pembayaran = $('#nilai_pembayaran_1').val()*2;
            other = $('#nilai_other_1').val()*2;
            total_1 = parseInt(harga) + parseInt(ketersediaan) + parseInt(pembayaran) + parseInt(other);
            $('#total_1').text(total_1);
            if(isNaN(total_1)){
                $('#total_1').text('-');
            }

            let name_0 = $('#vendor_name_0').text().trim();
            let name_1 = $('#vendor_name_1').text().trim();

            if(total_0 > total_1){
                $('#selected_vendor').text(name_0);
                isSelected = true;
            }else if(total_1 > total_0){
                $('#selected_vendor').text(name_1);
                isSelected = true;
            }else{
                $('#selected_vendor').text('-');
                isSelected = false;
                if(isNaN(total_1)){
                    $('#selected_vendor').text(name_0);
                    isSelected = true;
                }
            }
        });
        $('.nilai').eq(0).trigger('change');
    });
</script>
@endsection
