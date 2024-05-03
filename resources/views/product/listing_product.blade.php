@extends('layout.app')

@section('customstyle')
@stop

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Listing Products</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Listing Products</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header row">
                    <div class="col-6">
                        <h4>All Products</h4>
                    </div>
                    <div class="col-6" style="text-align:right">
                        <a type="button" class="btn btn-success" href="{{url('products/add')}}">Create New Products</a>
                    </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Details</th>
                    <th>Publish</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($datas as $product)
                    <tr>
                        <td class="text-sm font-weight-normal">{{$loop->index+1}}</td>
                        <td class="text-sm font-weight-normal">{{$product->name}}</td>
                        <td class="text-sm font-weight-normal">{{$product->price}}</td>
                        <td class="text-sm font-weight-normal">{{$product->details}}</td>
                        <td class="text-sm font-weight-normal">{{$product->publish}}</td>
                        <td>
                            <button type="button" class="btn btn-info show-product" 
                                data-toggle="modal" 
                                data-target="#myModal" 
                                data-name="{{$product->name}}" 
                                data-price="{{$product->price}}" 
                                data-details="{{$product->details}}" 
                                data-publish="{{$product->publish}}">
                                Show
                            </button>
                            <a type="button" class="btn btn-primary" href="{{url('products')}}/{{$product->id}}">Edit</a>
                            <a type="button" class="btn btn-danger" data-route="{{url('products')}}/{{$product->id}}" data-csrf="{{ csrf_token() }}" onclick="removeData2(this)">Delete</a>
                        </td>
                    </tr>
                  @endforeach
                  </tbody>
                  <!-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> -->
                </table>

                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Show Product</h4>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Back</button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <p><strong>Name:</strong> <span id="productName"></span></p>
                                <p><strong>Price:</strong> <span id="productPrice"></span></p>
                                <p><strong>Details:</strong> <span id="productDetails"></span></p>
                                <p><strong>Publish:</strong> <span id="productPublish"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('pagespecificscripts')
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){
    $('.show-product').click(function(){
        var name = $(this).data('name');
        var price = $(this).data('price');
        var details = $(this).data('details');
        var publish = $(this).data('publish');
        
        $('#productName').text(name);
        $('#productPrice').text(price);
        $('#productDetails').text(details);
        $('#productPublish').text(publish);
    });
});

$(document).ready(function() {
    $('#example2').DataTable({
        "searching": true // Enable search functionality
    });
});

function removeData2(button) {
    const swalCustomButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn bg-gradient-danger',
            cancelButton: 'btn bg-gradient-info',
          },
          buttonsStyling: false
        })
    const swalCustomButtons2 = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-info',
            },
            buttonsStyling: false
        })
      var route = $(button).data('route');
      swalCustomButtons.fire({
          icon: 'warning',
          title: 'Delete Confirmation',
          text: "Are you sure want to delete this data?",
          type: 'warning',
          showCancelButton: true,
          reverseButtons: true,
          confirmButtonText: "Delete"
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  type: "DELETE",
                  url: route,
                  dataType: 'JSON',
                  data:{
                    '_token': $(button).data('csrf')?$(button).data('csrf'):"",
                  },
                  success: function (response) {
                      console.log(response);
                      swalCustomButtons2.fire({
                          icon: 'success',
                          position: 'center',
                          type: 'success',
                          title: 'Data Deleted',
                          showButton: true,
                      })
                      setTimeout(function(){
                        window.location.reload();
                      }, 1500);
                  },
                  error: function (xhr, status, error) {
                      Swal.fire(
                          'Error!',
                          "This Data Unable To Delete!",
                          'error'
                      )
                      console.log(error);
                  }
              });
          }
      });
}
</script>
@endsection