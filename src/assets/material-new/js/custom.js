(function ($) {

    // Unsaved form protection
    var protectedFormChanged = false;
    $('body')
        .on('change', 'form.warn-lose-changes :input', function () {
            protectedFormChanged = true;
        })
        .on('beforeSubmit', 'form.warn-lose-changes', function () {
            protectedFormChanged = false;
        });

    $(window).on('beforeunload', function () {
        if (protectedFormChanged) {
            return 'Előfordulhat, hogy módosításait nem menti a rendszer.';
        }
    });

    // GridView pagesize-header fixes
    $(document).on('change', '#items-per-page-top', function () {
        $('#items-per-page-bottom')
            .val($(this).val())
            .trigger('change');
    });

})(window.jQuery);