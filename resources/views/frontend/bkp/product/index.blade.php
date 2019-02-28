@extends('admin.layouts.app')
@section('content')
<div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p>A free and open source Bootstrap 4 admin template</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="h1">
            {{ __('lang.product.index.title') }}
    
            <a style="" href="{{ route('admin.product.create') }}" class="btn btn-primary float-right">
                    {{ __('lang.product.create.text') }}
                </a>
        </div>
        <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Features</h3>
            <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Slug</th>
                          <th>Edit</th>
                          <th>Show</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($products as $product)
                        <tr>
                          <td>1</td>
                          <td><img src="{{ $product->image->smallUrl }}" style="max-height: 50px;" /></td>
                          <td>{{ $product->name }}</td>
                          <td>{{ $product->slug }}</td>
                          <td><a href='{{ route('admin.product.edit', $product->id) }}' >Edit</a></td>
                          <td><a href='{{ route('admin.product.show',$product->id) }}' >Show</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
          </div>
        </div>
        
      </div>
@endsection

@section('script')
<script type="text/javascript">
  
</script>
@endsection