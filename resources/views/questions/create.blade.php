@extends('app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
               <div class="panel panel-defau">
                   <div class="panel-heading">发布问题</div>
                   <div class="panel-body">
                       <form action="/questions" method="post">
                           <div class="form-group">
                               <label for="title">标题</label>
                               <input type="text" name="title" class="form-control" placeholder="标题" id="title">
                           </div>
                       <script id="container" name="body" type="text/plain"></script>
                       <button class="btn btn-success pull-right" type="submit">发布问题</button>
                       </form>
                   </div>
               </div>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@stop
