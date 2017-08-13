@extends('emails._layout')

@section('content')
  <tr>
    <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
      <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
        <tr>
          <td class="content-cell">
            <h1>Welcome, {{ $user->username }}!</h1>
            <p>感谢您在 {{ config('admin.title') }} 网站进行注册！</p>
            <p>请点击下面的链接完成注册：</p>
            <table class="attributes" width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td class="attributes_content">
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td class="attributes_item">
                       <a href="{{ route('confirm_email', $user->activation_token) }}">
              		      {{ route('confirm_email', $user->activation_token) }}
              		    </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <p>如果这不是您本人的操作，请忽略此邮件</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
@endsection
