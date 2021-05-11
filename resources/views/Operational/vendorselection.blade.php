@extends('Layout.app')

@section('local-css')
<style>
    #form_table thead{
        background-color: #76933C;
        border : 1px solid #000 !important;
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
<div class="content-body px-4">
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
            <input type="text" class="form-control" value="{{now()->format('d F Y')}}" readonly>
        </div>

        <div class="col-md-2 mt-3">Kelompok</div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
              <select class="form-control">
                <option>Asset</option>
                <option>Inventaris</option>
                <option>Lain-Lain</option>
              </select>
              <input type="text" class="form-control" placeholder="isi nama Kelompok Lain">
            </div>
            <div class="form-group">
            </div>
        </div>
    </div>
    @php
        $vendors = $ticket->ticket_vendor;
    @endphp
    <table class="table table-bordered" id="form_table">
        <thead>
            <tr>
                <th class="align-middle text-center" rowspan="5" class="align-middle text-center">No</th>
                <th class="align-middle text-center" rowspan="5" class="align-middle text-center">Penilaian</th>
                <th class="align-middle text-center" rowspan="5" class="align-middle text-center">Bobot</th>
                @for($i=0; $i<2; $i++)
                    <th colspan="3" class="text-center" id="vendor_name_{{$i}}">
                        {{($vendors->get($i)) ? $vendors->get($i)->name : '-'}}
                    </th>
                @endfor
                <th class="align-middle text-center" rowspan="5" class="align-middle text-center">Keterangan</th>
            </tr>
            <tr>
                @for($i=0; $i<2; $i++)
                    <th>Alamat</th>
                    <th colspan="2">
                        @if ($vendors->get($i))
                            @if ($vendors->get($i)->type == 0) 
                                {{$vendors->get($i)->vendor()->address}}
                            @else
                                -
                            @endif
                        @else
                            -
                        @endif
                    </th>
                @endfor
            </tr>
            <tr>
                @for($i=0; $i<2; $i++)
                    <th>PIC</th>
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
                @for($i=0; $i<2; $i++)
                    <th>Telp/HP</th>
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
            <tr class="table-success"><td colspan="10"><b>Price</b></td></tr>
            <tr>
                <td>1</td>
                <td>Harga</td>
                <td class="align-middle text-center" rowspan="4">5</td>
                @for ($i=0; $i<2; $i++)
                <td>
                    <input type="text" class="form-control rupiah" id="harga_awal_{{$i}}">
                </td>
                <td>
                    <input type="text" class="form-control rupiah" id="harga_akhir_{{$i}}">
                </td>
                <td class="align-middle text-center" rowspan="4">
                    <input type="number" class="form-control nilai" min="0" max="5" value="0" id="nilai_harga_{{$i}}">
                </td>
                @endfor
                <td class="align-middle text-center" rowspan="4">
                    <textarea class="form-control" rows="10" id="keterangan_harga"></textarea>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>PPN</td>
                @for ($i=0; $i<2; $i++)
                    <td>
                        <input type="text" class="form-control rupiah" id="ppn_awal_{{$i}}">
                    </td>
                    <td>
                        <input type="text" class="form-control rupiah" id="ppn_akhir_{{$i}}">
                    </td>
                @endfor
            </tr>
            <tr>
                <td>3</td>
                <td>Ongkos Kirim</td>
                @for ($i=0; $i<2; $i++)
                    <td>
                        <input type="text" class="form-control rupiah" id="send_fee_awal_{{$i}}">
                    </td>
                    <td>
                        <input type="text" class="form-control rupiah" id="send_fee_akhir_{{$i}}">
                    </td>
                @endfor
            </tr>
            <tr>
                <td>4</td>
                <td>Ongkos Pasang</td>
                @for ($i=0; $i<2; $i++)
                    <td>
                        <input type="text" class="form-control rupiah" id="apply_fee_awal_{{$i}}">
                    </td>
                    <td>
                        <input type="text" class="form-control rupiah" id="apply_fee_akhir_{{$i}}">
                    </td>
                @endfor
            </tr>

            {{-- Ketersediaan  Barang --}}
            <tr class="table-success"><td colspan="10"><b>Ketersediaan Barang</b></td></tr>
            <tr>
                <td>5</td>
                <td>Spesifikasi (merk/type)</td>
                <td class="align-middle text-center" rowspan="5">3</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <input type="text" class="form-control" id="specs_{{$i}}">
                </td>
                <td class="align-middle text-center" rowspan="5">
                    <input type="number" class="form-control nilai" min="0" max="3" value="0" id="nilai_ketersediaan_{{$i}}">
                </td>
                @endfor
                <td class="align-middle text-center" rowspan="5">
                    <textarea class="form-control" rows="12" id="keterangan_ketersediaan"></textarea>
                </td>
            </tr>
            <tr>
                <td>6</td>
                <td>Ready</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <input type="text" class="form-control" id="ready_{{$i}}">
                </td>
                @endfor
            </tr>
            <tr>
                <td>7</td>
                <td>Indent</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <input type="text" class="form-control" id="indent_{{$i}}">
                </td>
                @endfor
            </tr>
            <tr>
                <td>8</td>
                <td>Barang bergaransi</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <input type="text" class="form-control" id="garansi_{{$i}}">
                </td>
                @endfor
            </tr>
            <tr>
                <td>9</td>
                <td>Bonus</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <input type="text" class="form-control" id="bonus_{{$i}}">
                </td>
                @endfor
            </tr>

            {{-- Ketentuan Pembayaran --}}
            <tr class="table-success"><td colspan="10"><b>Ketentuan Pembayaran</b></td></tr>
            <tr>
                <td>10</td>
                <td>Credit / Cash</td>
                <td class="align-middle text-center" rowspan="2">2</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <select class="form-control" id="cc_{{$i}}">
                        <option value="credit">Credit</option>
                        <option value="cash">Cash</option>
                    </select>
                </td>
                <td class="align-middle text-center" rowspan="2">
                    <input type="number" class="form-control nilai" min="0" max="2" value="0" id="nilai_pembayaran_{{$i}}">
                </td>
                @endfor
                <td class="align-middle text-center" rowspan="2">
                    <textarea class="form-control" rows="5" id="keterangan_pembayaran"></textarea>
                </td>
            </tr>
            <tr>
                <td>11</td>
                <td>Menerbitkan Faktur Pajak</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <select class="form-control" id="pajak_{{$i}}">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </td>
                @endfor
            </tr>
        
            {{-- Informasi lain-Lain --}}
            <tr class="table-success"><td colspan="10"><b>Informasi Lain-lain</b></td></tr>
            <tr>
                <td>12</td>
                <td>Masa berlaku penawaran</td>
                <td class="align-middle text-center" rowspan="4">2</td>
                @for ($i=0; $i<2; $i++)
                <td colspan="2">
                    <div class="input-group">
                        <input type="number" class="form-control" value="0" min="0" id="period_{{$i}}">
                        <span class="input-group-text">Hari</span>
                    </div>                      
                </td>
                <td class="align-middle text-center" rowspan="4">
                    <input type="number" class="form-control nilai" min="0" max="2" value="0" id="nilai_other_{{$i}}">
                </td>
                @endfor
                <td class="align-middle text-center" rowspan="4">
                    <textarea class="form-control" rows="10" id="keterangan_nilai"></textarea>
                </td>
            </tr>
            <tr>
                <td>13</td>
                <td>Lama Pengerjaan</td>
                @for ($i=0; $i<2; $i++)
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control" value="0" min="0" id="time_awal_{{$i}}">
                            <span class="input-group-text">Hari</span>
                        </div>     
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control" value="0" min="0" id="time_akhir_{{$i}}">
                            <span class="input-group-text">Hari</span>
                        </div>     
                    </td>
                @endfor
            </tr>
            
            <tr>
                <td>14</td>
                <td>
                    <input type="text" class="form-control" id="optional_name_1">
                </td>
                @for ($i=0; $i<2; $i++)
                    <td>
                        <input type="text" class="form-control" id="optional1_awal_{{$i}}">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="optional1_akhir_{{$i}}">
                    </td>
                @endfor
            </tr>
            
            <tr>
                <td>15</td>
                <td>
                    <input type="text" class="form-control" id="optional_name_2">
                </td>
                @for ($i=0; $i<2; $i++)
                    <td>
                        <input type="text" class="form-control" id="optional2_awal_{{$i}}">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="optional2_akhir_{{$i}}">
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
        <h4 id="selected_vendor">Vendor A</h4>
    </center>
    <div class="form-group">
      <label class="required_field">Pilih Otorisasi</label>
      <select class="form-control">
      </select>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function() {
        $('#nilai_harga_0').change(function(){
            autonumber("#nilai_harga_0");
        });
        $('#nilai_ketersediaan_0').change(function(){
            autonumber("#nilai_ketersediaan_0");
        });
        $('#nilai_pembayaran_0').change(function(){
            autonumber("#nilai_pembayaran_0");
        });
        $('#nilai_other_0').change(function(){
            autonumber("#nilai_other_0");
        });
        $('#nilai_harga_1').change(function(){
            autonumber("#nilai_harga_1");
        });
        $('#nilai_ketersediaan_1').change(function(){
            autonumber("#nilai_ketersediaan_1");
        });
        $('#nilai_pembayaran_1').change(function(){
            autonumber("#nilai_pembayaran_1");
        });
        $('#nilai_other_1').change(function(){
            autonumber("#nilai_other_1");
        });

        $(this).on('change','.nilai',function() {
            // vendor 1
            let harga = $('#nilai_harga_0').val();
            let ketersediaan = $('#nilai_ketersediaan_0').val();
            let pembayaran = $('#nilai_pembayaran_0').val();
            let other = $('#nilai_other_0').val();
            let total_0 = parseInt(harga) + parseInt(ketersediaan) + parseInt(pembayaran) + parseInt(other);
            $('#total_0').text(total_0);

            // vendor 2
            harga = $('#nilai_harga_1').val();
            ketersediaan = $('#nilai_ketersediaan_1').val();
            pembayaran = $('#nilai_pembayaran_1').val();
            other = $('#nilai_other_1').val();
            total_1 = parseInt(harga) + parseInt(ketersediaan) + parseInt(pembayaran) + parseInt(other);
            $('#total_1').text(total_1);

            let name_0 = $('#vendor_name_0').text().trim();
            let name_1 = $('#vendor_name_1').text().trim();

            if(total_0 > total_1){
                $('#selected_vendor').text(name_0);
            }else{
                $('#selected_vendor').text(name_1);
            }
        });
    });
</script>
@endsection
