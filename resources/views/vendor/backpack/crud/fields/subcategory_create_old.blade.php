<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <select
            name="{{ $field['name'] }}"
            style="width: 100%"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_field'])
    >
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        {{-- <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        {{-- <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script> --}}
        <script>
            jQuery(document).ready(function ($) {
                // trigger select2 for each untriggered select2 box
                console.log($('[name={{ $field['name'] }}]'));
                $('[name={{ $field['name'] }}]').select2({
                    tpl: '<select></select>',
                    theme: "bootstrap",
                    ajax: {
                        url: '{{ route('subcategories-ajax') }}',
                        data: function (params) {
                            var parent_id = $("[name=category_id]").val();

                            if (parent_id === '') parent_id = -1;

                            return {
                                q: params.term,
                                parent_id: parent_id,
                                type: 'public'
                            };
                        }
                    }
                });
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}