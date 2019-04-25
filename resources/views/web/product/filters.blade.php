

        <div class="col-md-3">

            <h2>Filter >></h2>
            {{ Form::open(array('id' => 'filters_from', 'method' => 'get')) }}

            @foreach($attributes as $attribute)
                <div class="color-filter">


                    <h3>{{$attribute->nameTranslated}}</h3>


                    <div class="form-check">
                        <label class="form-check-label @if(!isset($old['attribute-' . $attribute->id])) active-filter @endif">
                            <input type="checkbox" class="form-check-input" name="attribute-{{$attribute->id}}[]" value="all" @if(isset($old['attribute-' . $attribute->id]) && is_array($old['attribute-' . $attribute->id]) && in_array('all', $old['attribute-' . $attribute->id])) checked @endif>{{trans('attribute.all')}}
                        </label>
                    </div>
                    @foreach($attribute->values as $attributeValue)
                        <div class="form-check">
                            <label class="form-check-label @if(isset($old['attribute-' . $attribute->id]) && is_array($old['attribute-' . $attribute->id]) && in_array($attributeValue->id, $old['attribute-' . $attribute->id])) active-filter @endif">
                                <input type="checkbox" class="form-check-input" name="attribute-{{$attribute->id}}[]" value="{{$attributeValue->id}}" @if(isset($old['attribute-' . $attribute->id]) && is_array($old['attribute-' . $attribute->id]) && in_array($attributeValue->id, $old['attribute-' . $attribute->id])) checked @endif>{{$attributeValue->valueTranslated}}
                            </label>
                        </div>
                    @endforeach

                </div>
            @endforeach

        {{--    <div class="size-filter">

                <h3>Veličina</h3>


                <div class="form-check">
                    <label class="form-check-label" for="check1">
                        <input type="checkbox" class="form-check-input" id="check1" name="velicina" value="2" checked>2
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="check2">
                        <input type="checkbox" class="form-check-input" id="check2" name="velicina" value="4">4
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="check3">
                        <input type="checkbox" class="form-check-input" id="check3" name="velicina" value="6">6
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="check4">
                        <input type="checkbox" class="form-check-input" id="check4" name="velicina" value="8">8
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="check5">
                        <input type="checkbox" class="form-check-input" id="check5" name="velicina" value="10">10
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="check6">
                        <input type="checkbox" class="form-check-input" id="check6" name="velicina" value="12">12
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="check7">
                        <input type="checkbox" class="form-check-input" id="check7" name="velicina" value="14">14
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="check8">
                        <input type="checkbox" class="form-check-input" id="check8" name="velicina" value="16">16
                    </label>
                </div>


            </div>--}}

            <div class="price-filter">

                <h3>{{trans('filters.price')}}</h3>


                <div class="form-check">
                    <label class="form-check-label" for="check1">
                        <input type="checkbox" class="form-check-input" id="check1" name="price" value="asc">{{trans('filters.ascending')}}
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="check2">
                        <input type="checkbox" class="form-check-input" id="check2" name="price" value="desc">{{trans('filters.descending')}}
                    </label>
                </div>


            </div>
            {{ Form::close() }}

        </div>




@section('after_scripts')
    <script>
        $(document).ready(function () {
            $("input.form-check-input").click(function () {
                var elementName = CSS.escape($(this).attr('name'));

                var label = $(this).parent();

                if(label.hasClass('active-filter')) {
                    label.removeClass('active-filter');
                }else{
                    label.addClass('active-filter');
                }

                if($(this).val() === 'all') {
                    $('input[name=' + elementName + ']:checked').each(function() {
                        console.log($(this));
                        $(this).prop("checked", false);
                        $(this).parent().removeClass('active-filter');
                    });
                    label.addClass('active-filter');
                }else{
                    $('input[name=' + elementName + ']:checked').each(function() {
                        if($(this).val() == 'all') {
                            $(this).prop("checked", false);
                            $(this).parent().removeClass('active-filter');
                        }
                    });
                }

                var checkValues = $('input[name=' + elementName + ']:checked').map(function()
                {
                    return $(this).val();
                }).get();

                $("#filters_from").submit();
            });
        });
    </script>
@endsection