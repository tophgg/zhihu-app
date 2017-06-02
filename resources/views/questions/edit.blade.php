
@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑问题</div>
                    <div class="panel-body">
                        <form action="/questions/{{ $question->id }}" method="post">
                            {{ method_field('PATCH') }}
                            {!! csrf_field() !!}
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">标题</label>
                                <input type="text" name="title" class="form-control" placeholder="标题" value="{{ $question->title }}" id="title">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="topics">话题</label>
                                <select name="topics[]" class="js-example-placeholder-multiple form-control" multiple="multiple">
                                    @foreach($question->topics as $topic)
                                        <option value="{{ $topic->id }}" selected="selected">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                                <!-- 编辑器容器 -->
                                <label for="body">描述</label>
                                <script id="container" name="body" type="text/plain">
                                    {!!  $question->body !!}
                                </script>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                                @endif
                            </div>


                            <button class="btn btn-success pull-right" type="submit">提交问题</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        $(document).ready(function() {
            // 模板返回数据时 进行样式的处理
            function formatTopic(topic){
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel" +
                    "</div></div></div>";
            }
            // 没有数据的话就读后端
            function formatTopicSelection(topic){
                return topic.name || topic.text;
            }

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 2,
                ajax: {
                    url: "/api/topics",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                templateResult: formatTopic, // omitted for brevity, see the source of this page
                templateSelection: formatTopicSelection // omitted for brevity, see the source of this page
            });
        });
    </script>
    @endsection
@endsection


