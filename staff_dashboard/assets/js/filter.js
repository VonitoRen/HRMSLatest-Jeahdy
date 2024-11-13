(function($) {
    "use strict";

    if ($('.select').length > 0) {
        $('.select').select2({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }

    if ($('.datetimepicker').length > 0) {
        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                up: "fa fa-angle-up",
                down: "fa fa-angle-down",
                next: 'fa fa-angle-right',
                previous: 'fa fa-angle-left'
            }
        });
        $('.datetimepicker').on('dp.show', function() {
            $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
        }).on('dp.hide', function() {
            $(this).closest('.temp').addClass('table-responsive').removeClass('temp');
        });
    }

    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    if ($('.datatable').length > 0) {
        $('.datatable').DataTable({
            "bFilter": false,
        });
    }

    if ($('.clickable-row').length > 0) {
        $(document).on('click', '.clickable-row', function() {
            window.location = $(this).data("href");
        });
    }

    $(document).on('click', '#check_all', function() {
        $('.checkmail').click();
        return false;
    });

    if ($('.checkmail').length > 0) {
        $('.checkmail').each(function() {
            $(this).on('click', function() {
                if ($(this).closest('tr').hasClass('checked')) {
                    $(this).closest('tr').removeClass('checked');
                } else {
                    $(this).closest('tr').addClass('checked');
                }
            });
        });
    }

    $(document).on('click', '.mail-important', function() {
        $(this).find('i.fa').toggleClass('fa-star').toggleClass('fa-star-o');
    });

    if ($('.summernote').length > 0) {
        $('.summernote').summernote({
            height: 200,
            minHeight: null,
            maxHeight: null,
            focus: false
        });
    }

    if ($('.proimage-thumb li a').length > 0) {
        var full_image = $(this).attr("href");
        $(".proimage-thumb li a").click(function() {
            full_image = $(this).attr("href");
            $(".pro-image img").attr("src", full_image);
            $(".pro-image img").parent().attr("href", full_image);
            return false;
        });
    }

    if ($('#pro_popup').length > 0) {
        $('#pro_popup').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
    }

})(jQuery);
