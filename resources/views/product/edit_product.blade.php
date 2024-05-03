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
            <h1 class="m-0">Edit Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-6">
                        <h4>Product</h4>
                    </div>
                    <div class="col-6" style="text-align:right">
                        <a class="btn bg-gradient-info" onclick="history.back()" role="button" ">Back</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form1">
                @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12 form-group">
                                <label for="product_name" class="col-form-label">
                                    Name :
                                </label>
                                <input class="form-control" type="text" value="{{$product->name}}" id="name" name="name" placeholder="Name">
                            </div>                            
                            <div class="col-md-12 form-group">
                                <label for="price" class="col-form-label">
                                    Price(RM) :
                                </label>
                                <input class="form-control" type="text" value="{{$product->price}}" id="price" name="price" placeholder="99.90" oninput="this.value = this.value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1'); if(this.value.includes('.')) { var parts = this.value.split('.'); if(parts[1].length > 2) { this.value = parts[0] + '.' + parts[1].slice(0, 2); } }">
                            </div>                            
                            <div class="col-md-12 form-group">
                                <label for="details" class="col-form-label">
                                    Detail :
                                </label>
                                <textarea class="form-control" rows="5" id="details" name="details" placeholder="Detail">{{$product->details}}</textarea>
                            </div>                            
                            <div class="col-md-12 form-group">
                                <label for="publish">Publish:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publish" id="publish_yes" value="Yes" {{ $product->publish == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publish_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publish" id="publish_no" value="No" {{ $product->publish == 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publish_no">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" style="display: block; margin: 0 auto;">Edit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endsection

@section('pagespecificscripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /*---form1 submit---*/
    $('#form1').submit(function(e){
        const swalCustomButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn bg-gradient-info',
            },
            buttonsStyling: false
        });
        e.preventDefault();
        var form = $(this)[0];  //selector for the current form

        //if form validation passed
        if(form.checkValidity() === true){
            //submit to backend
            var formData = new FormData(this);

            // Add method spoofing for Laravel
            formData.append('_method', 'PUT');

            // Extract the product ID from the URL
            var id = "{{ $product->id }}";

            $.ajax({
                url: "{{ url('products/'.$product->id) }}",
                type: "POST", // Use POST method for method spoofing
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log("success", response);
                    swalCustomButtons.fire({
                        icon: 'success',
                        position: 'center',
                        title: 'Data Updated Successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = "/products";
                    });
                },
                error: function (error){
                    console.log("error", error);
                    Swal.fire(
                        'Error!',
                        "Failed! Please try again.",
                        'error'
                    );
                }
            });
        }
    });
    /*---end form1 submit---*/
</script>
@endsection