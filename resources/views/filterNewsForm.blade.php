<div class="col-12 divFilter">
    <div class="col-6"
         style="background-color: #595959;padding: 10px;border-radius: 10px;user-select: none;">
        <form method="get" action="{{url($url)}}">
            <div id="toggleText" class="col-12" style="text-align: center;">
                    <span id="toggleText"
                          style="text-align: center;color: whitesmoke;font-weight: bolder;cursor: pointer">Filter NEWS</span>
                <i id="arrow" class="fas fa-chevron-down arrow-icon toggle-icon" style="color: white"></i>
                <!-- آیکون فلش -->
            </div>
            <div id="myDiv" class="col-12 hidden-div">
                <hr style="width: 100%">
                <div class="col-12 titlesFilter">
                    <a style="padding: 5px;">Instruments</a>
                </div>
                @foreach($instruments as $instrument)
                    <div class="col-4 checkBoxFilters">
                        @if(in_array($instrument->instrument,$lastInstrumentsFilters))
                            <input name="{{$instrument->instrument}}" type="checkbox" checked>
                            <a style="color: whitesmoke">{{$instrument->instrument}}</a>
                        @else
                            <input name="{{$instrument->instrument}}" type="checkbox">
                            <a style="color: whitesmoke">{{$instrument->instrument}}</a>
                        @endif
                    </div>
                @endforeach
                <hr style="width: 100%">
                <div class="col-12 titlesFilter">
                    <a style="padding: 5px;">Important</a>
                </div>
                <div class="col-12 checkBoxFilters">
                    <div class="col-4 checkBoxFilters">
                        @if($lastImportantState=="important")
                            <input name="important" value="important" type="radio" checked>
                            <a style="color: whitesmoke">Important NEWS</a>
                        @else
                            <input name="important" value="important" type="radio">
                            <a style="color: whitesmoke">Important NEWS</a>
                        @endif
                    </div>
                    <div class="col-4 checkBoxFilters">
                        @if($lastImportantState=="notImportant")
                            <input name="important" value="notImportant" type="radio" checked>
                            <a style="color: whitesmoke">Not Important NEWS</a>
                        @else
                            <input name="important" value="notImportant" type="radio">
                            <a style="color: whitesmoke">Not Important NEWS</a>
                        @endif
                    </div>
                    <div class="col-4 checkBoxFilters">
                        @if($lastImportantState=="both")
                            <input name="important" value="both" type="radio" checked>
                            <a style="color: whitesmoke">Both</a>
                        @else
                            <input name="important" value="both" type="radio">
                            <a style="color: whitesmoke">Both</a>
                        @endif
                    </div>

                </div>
                <div class="col-12" style="justify-content: center;display: flex">
                    <input class="btnApplyFilters" type="submit" name="applyFilters" value="Apply">
                </div>
            </div>
        </form>
    </div>
</div>
