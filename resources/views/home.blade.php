@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('/home/delete') }}">Delete All Selected</button>
                    <button style="margin-bottom: 10px;float:right" class="btn btn-success add" data-toggle="modal" data-target="#myModal" >Add Product </button>
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
                                        <td>{{ $product->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td><img src="{{url('/images/'.$product->image)}}"  width="50" height="60"></td>
                                        <td><a data-toggle="modal" data-id="{{$product->id}}" data-target="#myeditModal" class="btn btn-primary editModel" id="">Edit</a></td>
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

                    <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form >
      <div class="alert alert-success" id="success-alert" style="display:none">Product added sucessfully</div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name"  required>
                <div id="error_name" style="display:none" class="invalid-feedback" style="color:red"></div>
                
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" >
                <div id="error_price" style="display:none" class="invalid-feedback" style="color:red"></div>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" >
                <div id="error_image" style="display:none" class="invalid-feedback" style="color:red"></div>
            </div>
            <a onclick="submitaddform()" class="btn btn-primary">Submit</a>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


       <!-- The edit Modal -->
<div class="modal" id="myeditModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form >
      <div class="alert alert-success" id="success-alertt" style="display:none">Product updated sucessfully</div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="edit_name"  required>
                <input type="hidden" class="form-control" id="edit_id"  required>
                <div id="error_namee" style="display:none" class="invalid-feedback" style="color:red"></div>
                
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="edit_price" >
                <div id="error_pricee" style="display:none" class="invalid-feedback" style="color:red"></div>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="edit_status">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="edit_image" >
                <div id="error_imagee" style="display:none" class="invalid-feedback" style="color:red"></div>
            </div>
            <a onclick="submiteditform()" class="btn btn-primary">Submit</a>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
       

        $(".editModel").click(function(){
            var id = $(this).data('id');
            
            $.ajax({
                        url: '/home/edit/'+id,
                        type: 'GET',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        
                        success: function (data) {
                            $('#edit_name').val(data.name);
                            $('#edit_price').val(data.price);
                            $('#edit_id').val(id);
                            if(data.status == 1)
                            {
                                $('#edit_status option[value="1"]').attr("selected", "selected");
                            }
                            else{
                                $('#edit_status option[value="0"]').attr("selected", "selected");
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
        });

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

    function submitaddform()
        {

            var allowedFiles = /(\.jpg|\.jpeg|\.png)$/i;
            var name = $('#name').val();
            var price = $('#price').val();
            var image = $('#image');
            var imagee = $('#image');
            var status = $('#status option:selected').val();
            if(name == '')
            {
                $("#error_name").text("Please enter the name")
                $("#error_name").show();
                setTimeout(function() { $("#error_name").hide(); }, 4000);
                return false
            }
            else if(price == '')
            {
                $("#error_price").text("Please enter the price")
                $("#error_price").show();
                setTimeout(function() { $("#error_price").hide(); }, 4000);
                return false
            }

            
           

            

            else if(image.get(0).files.length === 0)
            {
                $("#error_image").text("please upload the image")
                $("#error_image").show();
                setTimeout(function() { $("#error_image").hide(); }, 5000);
                return false
            }
            else if (allowedFiles.exec(imagee.val().toLowerCase()) == null) {
                $("#error_image").text("please upload jpg,jpeg,png File")
                $("#error_image").show();
                setTimeout(function() { $("#error_image").hide(); }, 5000);
                return false
            }
            var fd = new FormData();
            var files = $('#image')[0].files;
            fd.append('image',files[0]);
            fd.append('name',name);
            fd.append('price',price);
            fd.append('status',status);
            


            $.ajax({
                headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
           type:'POST',
           url:"{{route('store')}}",
           processData: false,
           contentType: false,
           data:fd,
           success:function(data){
            $("#success-alert").show();
            setTimeout(function() { $("#success-alert").hide(); }, 5000);
            location.reload();
           }
        });
            
        }

        function submiteditform()
        {

            var allowedFiles = /(\.jpg|\.jpeg|\.png)$/i;
            var name = $('#edit_name').val();
            var id = $('#edit_id').val();
            var price = $('#edit_price').val();
            var image = $('#edit_image');
            var imagee = $('#edit_image');
            var status = $('#edit_status option:selected').val();
            if(name == '')
            {
                $("#error_namee").text("Please enter the name")
                $("#error_namee").show();
                setTimeout(function() { $("#error_namee").hide(); }, 4000);
                return false
            }
            else if(price == '')
            {
                $("#error_pricee").text("Please enter the price")
                $("#error_pricee").show();
                setTimeout(function() { $("#error_pricee").hide(); }, 4000);
                return false
            }

            
           

            

            else if(image.get(0).files.length !== 0)
            {
                if (allowedFiles.exec(imagee.val().toLowerCase()) == null) {
                $("#error_imagee").text("please upload jpg,jpeg,png File")
                $("#error_imagee").show();
                setTimeout(function() { $("#error_imagee").hide(); }, 5000);
                return false
            }
            }
            
            var fd = new FormData();
            if(image.get(0).files.length !== 0)
            {
                var files = $('#edit_image')[0].files;
                fd.append('image',files[0]);
            }
            
            fd.append('name',name);
            fd.append('price',price);
            fd.append('status',status);
            fd.append('id',id);


            $.ajax({
                headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
           type:'POST',
           url:"{{route('update')}}",
           processData: false,
           contentType: false,
           data:fd,
           success:function(data){
            $("#success-alertt").show();
            setTimeout(function() { $("#success-alertt").hide(); }, 5000);
            location.reload();
           }
        });
            
        }
</script>

@endsection
