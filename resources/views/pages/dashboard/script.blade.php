<script>
    $(document).ready(function() {
        $('#Dtable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('/') }}",
                "type": "GET",
            },
            columns: [
                { data: 'DT_RowIndex', sClass: 'text-center', orderable: false, searchable: false },
                { data: 'created_at', },
                { data: 'nm_toko' },
                { data: 'no_faktur' },
                { data: 'tgl_faktur' },
                { data: 'tgl_tiba' },
                { data: 'pejabat' },
                { data: 'status' },
                { data: 'act', sClass: 'text-center', orderable: false, searchable: false }
            ],
            order: []
        });
    });

    function onStatusRetur(obj_status, urut_item) {
        console.log(obj_status);
        if(obj_status == "Terima") {
            $('#catatan'+urut_item).prop('readonly', true);
            $('#catatan'+urut_item).val('');
        }else{
            $('#catatan'+urut_item).prop('readonly',false);
            $('#catatan'+urut_item).val('')
        }
    }

    function show_data(id) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('retur/find') }}/"+id,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(result) {
                console.log(result);
                var temp_data = '';
                if(result.data.item_retur.length > 0) {
                    var urut = 1;
                    $.each(result.data.item_retur, function(key, item) {
                        var select_status = '';
                        var catatan = '';
                        if(result.data.status != 'Selesai') {
                            @if (auth()->user()->level == 'Toko')
                                select_status = item.status ? item.status : '-';
                            @else
                                select_status = "<select class='form-control' onChange='onStatusRetur(this.value, "+urut+")' name='status"+urut+"' id='status"+urut+"'><option>Terima</option><option>Tolak</option></select>";
                            @endif
                            catatan = "<input type='text' class='form-control' name='catatan"+urut+"' readonly id='catatan"+urut+"' placeholder='Catatan'>";
                        }else{
                            select_status = item.status ? item.status : '-';
                            catatan = item.catatan ? item.catatan : '-';
                        }

                        var qty = item.qty ? item.qty : '';
                        var bta = item.bta ? item.bta : '';
                        var sb = item.sb ? item.sb : '';
                        var bl = item.bl ? item.bl : '';
                        var bk = item.bk ? item.bk : '';
                        var bnf = item.bnf ? item.bnf : '';
                        var brp = item.brp ? item.brp : '';
                        var keterangan = item.keterangan ? item.keterangan : '';

                        temp_data = temp_data+"<tr>"
                            +"<td>"+item.plu+" - "+item.nm_produk+"</td>"
                            +"<td>"+qty+"</td>"
                            +"<td>"+bta+"</td>"
                            +"<td>"+sb+"</td>"
                            +"<td>"+bl+"</td>"
                            +"<td>"+bk+"</td>"
                            +"<td>"+bnf+"</td>"
                            +"<td>"+brp+"</td>"
                            +"<td>"+keterangan+"</td>"
                            +"<td><input type='hidden' name='urut[]' value='"+urut+"'><input type='hidden' name='item_id"+urut+"' value='"+item.id+"'> "+select_status+"</td>"
                            +"<td>"+catatan+"</td>"
                            +"</tr>";
                        urut++;
                    });
                }
                $('#modal-size').attr('class', 'modal-dialog modal-xl');
                $('#modal-title').html('Detail Data');
                $('#modal-body').html('<form id="Dform">'
                    +'<div class="row">'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">Kode Toko</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="text" class="form-control" placeholder="Kode Faktur" disabled value="'+result.data.kd_toko+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">Nama Toko</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="text" class="form-control" placeholder="Nama Toko" disabled value="'+result.data.nm_toko+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">No. Faktur</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="text" class="form-control" placeholder="No Faktur" disabled value="'+result.data.no_faktur+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">Tgl Faktur</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="date" class="form-control" placeholder="Tanggal Tiba" disabled value="'+result.data.tgl_tiba+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">Tgl Tiba</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="date" class="form-control" placeholder="Tanggal Faktur" disabled value="'+result.data.tgl_faktur+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">Pejabat</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="text" class="form-control" placeholder="Pejabat" disabled value="'+result.data.pejabat+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-6">'
                            +'<div class="form-group row align-items-center">'
                                +'<div class="col-lg-2 col-3">'
                                    +'<label class="col-form-label">No Plat / Mu</label>'
                                +'</div>'
                                +'<div class="col-lg-10 col-9">'
                                    +'<input type="text" class="form-control" placeholder="No Plat MU" disabled value="'+result.data.no_plat_mu+'">'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                    +'<hr>'
                    +'<div class="table-responsive">'
                        +'<table id="Dtable" class="table table-bordered mb-0">'
                            +'<thead>'
                                +'<tr>'
                                    +'<th width="10%">Plu / Produk</th>'
                                    +'<th>Qty Dalam Cont</th>'
                                    +'<th>BTA</th>'
                                    +'<th>SB</th>'
                                    +'<th>Bl</th>'
                                    +'<th>Bk</th>'
                                    +'<th>BNF</th>'
                                    +'<th>BRP</th>'
                                    +'<th width="20%">Ket / Plu SB</th>'
                                    +'<th>Status</th>'
                                    +'<th>Catatan</th>'
                                +'</tr>'
                            +'</thead>'
                            +'<tbody>'+temp_data+'</tbody>'
                        +'</table>'
                    +'</div>'
                    +'</form>');

                    if(result.data.status != 'Selesai') {
                        @if (auth()->user()->level == 'Admin')
                            $('#modal-footer').html('<button type="button" onclick="location.reload();" class="btn btn-light-primary" data-bs-dismiss="modal">'
                                    +'<i class="bx bx-x d-block d-sm-none"></i>'
                                    +'<span class="d-none d-sm-block">Close</span>'
                                +'</button>'
                                +"<button type='button' onclick=\"$('#Dform').submit()\" class='btn btn-primary me-1 mb-1'>"
                                    +'<span class="d-none d-sm-block">Save</span>'
                                +'</button>');
                            $('#modal-footer').show();
                        @else
                            $('#modal-footer').html('');
                            $('#modal-footer').hide();
                        @endif
                    }else{
                        $('#modal-footer').html('');
                        $('#modal-footer').hide();
                    }
                    $('#btn-close-modal').attr('onclick','location.reload();');
                    $('#modal-detail').modal('show');

                    // Update Status
                    $('#Dform').on('submit', function(event) {
                        event.preventDefault();
                        idata = new FormData($('#Dform')[0]);
                        idata.append('_token', tokenCSRF);
                        idata.append('_method', "PUT");
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "{{ asset('retur/update_status') }}/"+id,
                            data: idata,
                            processData: false,
                            contentType: false,
                            cache: false,
                            beforeSend: function() {
                                in_load();
                            },
                            success: function(data) {
                                Swal.fire(''+data.status+'',''+data.messages+'','success').then((value) => {
                                    window.location.href = "{{ asset('/') }}";
                                });
                                out_load();
                            },
                            error: function(error) {
                                error_detail(error);
                                out_load();
                            }
                        });
                    });
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    }

    // Greeting
    function greeting() {
        let asiaTime = new Date().toLocaleString('en-US', {
            timeZone: 'Asia/Makassar'
        });
        asiaTime = new Date(asiaTime);
        let hours = asiaTime.getHours();
        if(hours <= 10) msg = 'Selamat Pagi !';
        if(hours >= 11) msg = 'Selamat Siang !';
        if(hours >= 16) msg = 'Selamat Sore !';
        if(hours >= 19) msg = 'Selamat Malam !';

        return msg;
    }
</script>
