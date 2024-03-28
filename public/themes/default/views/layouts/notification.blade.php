$(document).ready(function(){
toastr.{{ $type ?? 'info' }}('{{$message}}');
toastr.options = {
"closeButton": true,
"debug": false,
"newestOnTop": false,
"progressBar": false,
"positionClass": "toast-top-right",
"preventDuplicates": false,
"onclick": null,
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
};
{{--  $.notify({--}}
{{--    // Oprions--}}
{{--    icon: 'fas fa-{{ $icon ?? 'paw' }}',--}}
{{--    title: "<strong>{{ trans('theme.' . $type) }}:</strong> ",--}}
{{--    message: '{{ $message ?? '' }}'--}}
{{--  },{--}}
{{--    // Settings--}}
{{--    type: '{{ $type ?? 'info' }}',--}}
{{--    delay: 400,--}}
{{--    placement: {--}}
{{--      from: "bottom",--}}
{{--      align: "center"--}}
{{--    }--}}
{{--  });--}}
});
