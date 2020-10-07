$(document).ready(function () {
    $(document).on('change', '.header__region select', function () {
        if ($(this).data('type') == 'DOMAIN') {
            domain = $(this).data('domain');
            if ($(this).val() != 0) {
                domain = $(this).val() + '.' + domain;
            }

            document.location.href = '//' + domain + location.pathname;
        } else {
            $.post(location.href, { region: $(this).val() })
                .done(function () {
                    document.location.href = location.href;
                });
        }
    });
})