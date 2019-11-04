if ($.fn.tooltip && $('[data-toggle="tooltip"]').length) {
    $('[data-toggle="tooltip"]').tooltip().on("mouseleave", function () {
        $(this).tooltip('hide');
    });
}

$(document).on('click', 'a[data-method]', function () {
    let $object = $(this);

    let $tokenInput = $('<input>')
        .attr('name', '_token')
        .attr('value', $('meta[name=csrf-token]').attr('content'))
        .attr('type', 'hidden');

    let $methodInput = $('<input>')
        .attr('name', '_method')
        .attr('value', $object.data('method'))
        .attr('type', 'hidden');

    let $form = $('<form>')
        .attr('method', 'POST')
        .attr('action', $object.attr('href'))
        .append($tokenInput)
        .append($methodInput);

    $form.appendTo('body').submit();

    return false;
});

$(function () {
    $('.selectpicker').selectpicker()
        .on('changed.bs.select', selectPickerReplaceClass)
        .on('loaded.bs.select', selectPickerReplaceClass);

    function selectPickerReplaceClass(e, clickedIndex, isSelected, previousValue) {
        var $self = $(e.currentTarget);
        var $selected = $self.find(':selected');
        var $button = $self.parent().find('button');

        if ($selected.data('style')) {
            var oldStyle = $self.attr('data-style');
            var newStyle = $selected.attr('data-style');

            $self.attr('data-style', newStyle);
            $button.removeClass(oldStyle);
            $button.addClass(newStyle);
        }
    }
});

$(function () {
    $('.translit-slug-button').on('click', function () {
        $('input[name=' + $(this).data('slug') + ']').val(
            generateUrl($('input[name=' + $(this).data('name') + ']').val())
        );
    });
});

function generateUrl(url) {
    url = url.replace(/[\s]+/gi, '-');
    url = translit(url);
    url = url.replace(/[^0-9a-z_\-]+/gi, '').toLowerCase();
    return url;
}

function translit(str) {
    let ru = ("А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я").split("-");
    let en = ("A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch-'-'-Y-y-'-'-E-e-YU-yu-YA-ya").split("-");
    let res = '';

    for (let i = 0, l = str.length; i < l; i++) {
        let s = str.charAt(i), n = ru.indexOf(s);

        if (n >= 0) {
            res += en[n];
        }
        else {
            res += s;
        }
    }

    return res;
}