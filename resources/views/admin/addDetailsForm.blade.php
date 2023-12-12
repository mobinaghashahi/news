<div class="col-12"
     style="border: black solid 2px;justify-content: center;display: flex;padding: 10px 0px 10px 0px;margin-top: 10px" id="{{$details_id}}">
    <!-- ues from add new details -->
    <input id="idDetails_{{$details_id}}" type="text" name="idDetails_{{$details_id}}"
           value="{{$details_id}}" hidden>
    <div class="col-11">
        <a class="delete" style="cursor: pointer">
            <img src="/logo/deleteRed.png" width="20" height="20" style="float: right">
            <input type="text" name="{{$details_id}}"
                   value="{{$details_id}}" hidden>
        </a>
        <div class="col-12">
            <a>INSTRUMENT:<input name="instrument_{{$details_id}}" class="inputText"
                                 placeholder="INSTRUMENT" value=""></a>
        </div>
        <div class="col-12">
            <a>EFFECT:</a>
            <div class="col-12">
                @for($i=-4;$i<=4;$i++)
                    <label for="child">{{$i}}</label>
                    <input type="radio" id="{{$details_id}}" name="effect_{{$details_id}}" value="{{$i}}" checked>
                @endfor
            </div>
        </div>
        <div class="col-12">
            <a>IMPORTANT:</a>
            <a>YES: <input type="radio" id="important"
                           name="important_{{$details_id}}"
                           value="1"></a>
            <a>NO: <input type="radio" id="important"
                          name="important_{{$details_id}}"
                          value="0" checked></a>
        </div>
        <div class="col-12">
            <a>COMMENT: <input name="comment_{{$details_id}}" class="inputText"
                               placeholder="comment" value=""></a>
        </div>
    </div>
</div>
