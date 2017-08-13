@extends('emails._layout')

@section('content')
<tr>
  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
    <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
      <tr>
        <td class="content-cell">
          <p>Notification 提醒您：</p>
          <p>Coding 有最新动态： </p>
          <table class="attributes" width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td class="attributes_content">
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="attributes_item">
                      <strong>项目：</strong> 
                        Test
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="attributes_item">
                      <strong>工程师：</strong> 
                        Test
                    </td>
                  </tr>

                  <tr>
                    <td class="attributes_item">
                      <strong>提交分支：</strong> 
                        Test
                    </td>
                  </tr>

                  <tr>
                    <td class="attributes_item">
                      <strong>提交信息：</strong> 
                        Test
                    </td>
                  </tr>

                  <tr>
                    <td class="attributes_item">
                      <strong>详细信息请点击：</strong> 
                        Test
                    </td>
                  </tr>

                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td>
</tr>

@endsection
