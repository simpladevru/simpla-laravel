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
    $('select').selectpicker()
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