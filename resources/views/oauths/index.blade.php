@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>
        	服务授权
        	<small>通过授权，不用去第三方网站就可以在 Notification 里完成对应的设置。</small>
        </h1>
    </section>

    <section class="content">  

    @if(0 != count($authService))
      <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-key"></i> 已授权的服务 </h3>
        </div>
        <div class="box-body">
          <div class="row">
          	@foreach($authService as $auth)
          	<div class="col-md-3">
	          <div class="box box-solid">
	            <div class="box-header with-border">
	              <h3 class="box-title">{{ $auth->name }}</h3>
	              <span class="pull-right"><a href='{{ url("unoauths/$auth->id") }}' class="text-muted"><i class="fa fa-minus-circle"></i></a></span>
	            </div>
	            <div class="box-body">
	              <p>{{ $auth->description }}</p>             
	            </div>
	          </div>
	        </div>
	        @endforeach

          </div>
        </div>
      </div>
    @endif

      @if(0 != count($unauthService))
      <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-lock"></i> 未授权的服务 </h3>
        </div>
        <div class="box-body">
          <div class="row">
          	@foreach($unauthService as $unauth)
          	<div class="col-md-3">
	          <div class="box box-solid">
	            <div class="box-header with-border">
	              <h3 class="box-title">{{ $unauth->name }}</h3>
	              <span class="pull-right"><a href='{{ url("oauths/$unauth->id") }}' class="text-muted"><i class="fa fa-plus-circle"></i></a></span>
	            </div>
	            <div class="box-body">
	              <p>{{ $unauth->description }}</p>             
	            </div>
	          </div>
	        </div>
	        @endforeach

          </div>
        </div>
      </div>
    </section>
    @endif

    @include('admin::partials.error')
    @include('admin::partials.success')
    @include('admin::partials.exception')
	@include('admin::partials.toastr')

@endsection
