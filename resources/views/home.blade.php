@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('/home/delete') }}">Delete All Selected</button>
                    <table class="table table-bordered data-table">
                        <tr>
                                <th width="50px"><input type="checkbox" id="master"></th>
                                <th width="80px">No</th>
                                <th>Name</th>
                                <th>Price</th>

                                <th>UPS</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th width="100px">Edit</th>
                                <th width="100px">Delete</th>
                            </tr>
                            @if($products->count())
                                @foreach($products as $key => $product)
                                    <tr id="tr_{{$product->id}}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$product->id}}"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->ups }}</td>
                                        <td>{{ $product->status }}</td>
                                        <td>{{ $product->image }}</td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm delete_single"
                                            data-tr="tr_{{$product->id}}"
                                            data-idd="{{$product->id}}"
                                            data-toggle="confirmation"
                                            data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                                            data-btn-ok-class="btn btn-sm btn-danger"
                                            data-btn-cancel-label="Cancel"
                                            data-btn-cancel-icon="fa fa-chevron-circle-left"
                                            data-btn-cancel-class="btn btn-sm btn-default"
                                            data-title="Are you sure you want to delete ?"
                                            data-placement="left" data-singleton="true">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                    </table>
                </div>
            </div>
        </div>

            
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
       


        $('#master').on('click', function(e) {
           
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });

        $('.delete_single').on('click', function(e) {
            id = $(this).attr('data-idd');
            $.ajax({
                        url: '/home/delete/'+id,
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        
                        success: function (data) {
                            if (data['success']) {
                                
                                alert(data['success']);
                                location.reload();
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

        });

        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  


                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                
                                alert(data['success']);
                                location.reload();
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });

    
</script>

@endsection
