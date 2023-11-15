<script>
    var list_produk = [];
    var all_urut = [];

    function add_temp(urut) {
        in_load();
        urut = urut+1;
        var item_retur = $('#temp_item_retur');
        if(all_urut.length <= 0) {
            item_retur.html("");
        }
        all_urut.push(urut);
        var opt_produk = "<option value=''>:Pilih Produk:</option>";
        $.each(list_produk, function(key, item) {
            opt_produk = opt_produk+"<option value='"+item.id+"'>"+item.plu+" - "+item.nm_produk+"</option>";
        });
        item_retur.append(
            '<tr id="row_temp'+urut+'">'
                +'<td>'
                    +'<input type="hidden" name="item_id[]" value="0">'
                    +'<input type="hidden" name="urut[]" value="'+urut+'">'
                    +'<button type="button" class="btn btn-danger" onclick="delete_temp('+urut+')">'
                        +'<i class="fa fa-trash"></i>'
                    +'</button>'
                +'</td>'
                +'<td>'
                    +'<select type="text" name="produk_id'+urut+'" id="produk_id'+urut+'" class="form-control" onchange="checkduplikat(this)" placeholder="Qty Dalam Cont">'+opt_produk+'</select>'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="qty'+urut+'" id="qty'+urut+'" class="form-control" placeholder="Qty Dalam Cont">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="bta'+urut+'" id="bta'+urut+'" class="form-control" placeholder="Bta">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="sb'+urut+'" id="sb'+urut+'" class="form-control" placeholder="Sb">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="bl'+urut+'" id="bl'+urut+'" class="form-control" placeholder="Bl">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="bk'+urut+'" id="bk'+urut+'" class="form-control" placeholder="Bk">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="bnf'+urut+'" id="bnf'+urut+'" class="form-control" placeholder="Bnf">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="brp'+urut+'" id="brp'+urut+'" class="form-control" placeholder="Brp">'
                +'</td>'
                +'<td>'
                    +'<input type="text" name="ket'+urut+'" id="ket'+urut+'" class="form-control" placeholder="Ket">'
                +'</td>'
            +'</tr>'
        );

        $("#btn_add_temp").attr("onclick","add_temp("+urut+")");
        out_load();
    }

    function delete_temp(urut) {
        $('#row_temp'+urut).remove();
        all_urut = remove_item_array(all_urut, urut);
        if(all_urut.length <= 0) {
            $('#temp_item_retur').html(
                '<tr> <td colspan="10" class="text-center">Data Belum Ada</td> </tr>'
            );
        }
    }

    function remove_item_array(arr, item) {
	    return arr.filter(f => f !== item);
    }

    function load_produk() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('produk') }}",
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                console.log(data);
                $.each(data.data, function(key, item) {
                    list_produk.push(item);
                });
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    }

    $(function() {
        load_produk();
    });

    function checkduplikat(obj) {
        var duplikat = 0;
        var nameobj = obj.name;
        var valueobj = obj.value;
        $.each(all_urut, function (key, item)  {
            if(nameobj!="produk_id"+item) {
                var inputlain = $("#produk_id"+item).val();
                if(inputlain==valueobj) {
                    Swal.fire('Warning','duplikat data','warning').then((value) => {
                        obj.value = ""; $("#"+nameobj).focus();
                    });
                }
            }
        });
    }

    // Create Data
    $('#Addform').on('submit', function(e) {
        e.preventDefault();
        idata = new FormData($('#Addform')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ asset('retur/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                Swal.fire(''+data.status+'',''+data.messages+'','success').then((value) => {
                    window.location.href = "{{ asset('retur') }}";
                });
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    });
</script>
