@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>项目配置</h1>
    </section>

    <section class="content">  
      <div class="row">
        <div class="col-md-12">        
          <div class="box box-info">

          <div class="box-header with-border">
            <h3 class="box-title">Setting</h3>
            <div class="box-tools">
              <div class="btn-group pull-right" style="margin-right: 10px">
                <a href="{{ url('projects') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
              </div>
              <div class="btn-group pull-right" style="margin-right: 10px">
                <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
              </div>
            </div>
          </div>

            <form class="form-horizontal" method="post" action='{{ url("projects/{$project->id}/setting") }}'>
              <div class="box-body">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Project Name</label>
                  <div class="col-sm-10">
                    <span class="form-control">{{ $project->name }}</span> 
                 </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Coding WebHook</label>
                  <div class="col-sm-8">
                    <span class="form-control" style="overflow: hidden;">{{ 'http://' . $_SERVER['HTTP_HOST'] . '/webhook/'. $project->webhook . '?info=coding' }}</span> 
                    <span class="help-block">
                        <i class="fa fa-info-circle"></i>&nbsp; 查看如何配置 <a href="https://todayqq.gitbooks.io/notification/content/coding-webhook.html" target="_blank">Coding WebHook</a>
                    </span>
                 </div>
                 <!-- <div class="col-sm-4">
                      <button type="button" class="btn btn-info">测试</button>
                  </div> -->
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">GitHub WebHook</label>
                  <div class="col-sm-8">
                    <span class="form-control" style="overflow: hidden;">{{ 'http://' . $_SERVER['HTTP_HOST'] . '/webhook/'. $project->webhook . '?info=github' }}</span> 
                    <span class="help-block">
                        <i class="fa fa-info-circle"></i>&nbsp; 查看如何配置 <a href="https://todayqq.gitbooks.io/notification/content/github-webhook.html" target="_blank">GitHub WebHook</a>
                    </span>
                 </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Sentry WebHook</label>

                  <div class="col-sm-8">
                    <span class="form-control" style="overflow: hidden;">{{ 'http://' . $_SERVER['HTTP_HOST'] . '/webhook/'. $project->webhook . '?info=sentry' }}</span> 

                    <span class="help-block">
                        <i class="fa fa-info-circle"></i>&nbsp; 查看如何配置 <a href="https://todayqq.gitbooks.io/notification/content/sentry-webhook.html" target="_blank">Sentry WebHook</a>
                    </span>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="email_status" name="email_status" value="1"
                          @if($project->email_status)
                            checked="checked"
                          @endif
                        > 开启邮件通知
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">邮件通知人</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" id="user_email" name="send_email_users[]" multiple="multiple" 
                    @if(!$project->email_status)
                      disabled="disabled"
                    @endif>
                      @if(isset($userEmails))
                        @foreach($userEmails as $userEmail)
                          <option value="{{ $userEmail->id }}"
                            @if($project->send_email_users && $userEmail->id && in_array($userEmail->id, $project->send_email_users))
                              selected="selected"
                            @endif

                          >{{ $userEmail->email }}</option>>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

              @if(null != $teambitionArr['token'])
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Teambition 项目</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" id="tb_projectlist" style="width: 100%;" name="tb_pid">
                      <option value=""></option>
                      @if(isset($teambitionArr['projectList']))
                        @foreach($teambitionArr['projectList'] as $tbProject)
                          <option value="{{ $tbProject->_id }}" 
                            @if($project->tb_pid == $tbProject->_id)
                              selected="selected"
                            @endif
                          >{{ $tbProject->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="coding_msg_status" value="1"
                          @if($project->coding_msg_status)
                            checked="checked"
                          @endif
                        > Coding 消息推送至 Teambition 讨论组
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="sentry_msg_status" value="1"
                          @if($project->sentry_msg_status)
                            checked="checked"
                          @endif
                        > Sentry 报警推送至 Teambition 讨论组
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Teambition 任务分组</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" id="tb_tasklist" name="tb_tasklistid">
                      @if(isset($teambitionArr['taskList']))
                        @foreach($teambitionArr['taskList'] as $tbTask)
                          <option value="{{ $tbTask->_id }}"
                            @if($project->tb_tasklistid == $tbTask->_id)
                              selected="selected"

                              <?php $tbStages = $tbTask->hasStages ?>

                            @endif
                          >{{ $tbTask->title }}</option>>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Teambition 任务阶段</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" id="tb_stage" name="tb_stageid">
                      @if(isset($tbStages))
                        @foreach($tbStages as $tbStage)
                          <option value="{{ $tbStage->_id }}"
                            @if($project->tb_stageid == $tbStage->_id)
                              selected="selected"
                            @endif
                          >{{ $tbStage->name }}</option>>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Teambition 任务指派人</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" id="tb_executor" name="tb_executorid">
                      @if(isset($teambitionArr['person']))
                        @foreach($teambitionArr['person'] as $tbPerson)
                          <option value="{{ $tbPerson->_id }}"
                            @if($project->tb_executorid == $tbPerson->_id)
                              selected="selected"
                            @endif
                          >{{ $tbPerson->name }}</option>>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Teambition 任务相关人</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" id="tb_person" name="tb_personid[]" multiple="multiple">
                      @if(isset($teambitionArr['person']))
                        @foreach($teambitionArr['person'] as $tbPerson)
                          <option value="{{ $tbPerson->_id }}"
                            @if($project->tb_personid && $tbPerson->_id && in_array($tbPerson->_id, $project->tb_personid))
                              selected="selected"
                            @endif

                          >{{ $tbPerson->name }}</option>>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              @endif
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <script type="text/javascript" src="{{ asset('packages/admin/AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        // function notification(pid, type) {
        //   if (!pid || !type) return;
        //   $.ajax({
        //     url: 'projects/' + 'pid' + '/notification/' + type,
        //     success: function (re) {
              
        //     }
        //   })
        // }

        $('.select2').select2();

        $('.form-history-back').on('click', function () {
            event.preventDefault();
            history.back(1);
        });

        $("#email_status").on('change', function() {
            if(!$(this)[0].checked){
              $('#user_email').attr('disabled', 'disabled');
            } else {
              $('#user_email').removeAttr('disabled');
            }
        });

        $('#tb_projectlist').on('change', function () {
            $.ajax({
                url: "/teambition/" + $(this).val() + "/getTaskList",
                data: {
                  'token': "{{ $teambitionArr['token']['access_token'] }}"
                },
                success: function(re) {
                    $('#tb_tasklist').empty();
                    for (var i = 0; i < re.length; i++) {
                        var option;
                        if ('工单系统' == re[i].title) {
                            option = "<option value='" + re[i]._id + "' selected='selected'>" + re[i].title + "</option>";
                            createTbStage(re[i].hasStages)
                        } else {
                            option = "<option value='" + re[i]._id + "'>" + re[i].title + "</option>";
                        }
                        $('#tb_tasklist').append(option);
                    }
                }
            });

            function createTbStage(stage) {
                $('#tb_stage').empty();
                for (var i = 0; i < stage.length; i++) {
                    $('#tb_stage').append("<option value='" + stage[i]._id + "'>" + stage[i].name + "</option>");
                }
            }

            $.ajax({
                url: "/teambition/" + $(this).val() + "/getPerson",
                data: {
                  'token': "{{ $teambitionArr['token']['access_token'] }}"
                },
                success: function(re) {
                    $('#tb_executor').empty();
                    for (var i = 0; i < re.length; i++) {
                        var option = "<option value='" + re[i]._id + "'>" + re[i].name + "</option>";
                        $('#tb_executor').append(option);
                        $("#tb_person").append(option);
                    }
                }
            });
        })
        
    </script>
@endsection
