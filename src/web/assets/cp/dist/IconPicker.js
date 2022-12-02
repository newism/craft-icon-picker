window.Newism = window.Newism || {};

(function ($) {
    Newism.IconPicker = function(element, settings) {
        const $element = $(element);
        $element.selectize({
            dropdownParent: 'body',
            valueField: "filename",
            labelField: "filename",
            searchField: ["filename"],
            options: $element.data('iconPickerOptions'),
            optgroups: $element.data('iconPickerOptgroups'),
            optgroupField: 'folder',
            optgroupLabelField: 'folder',
            optgroupValueField: 'folder',
            render: {
                item: function (item, escape) {
                    return `<div class='nsm-icon-picker-item'>
                                <img src="${escape(item.src)}" loading="lazy" alt="" role="presentation" />
                                <span>${escape(item.filename)}</span>
                            </div>`;
                },
                option: function (item, escape) {
                    return `<div class='nsm-icon-picker-option'>
                                <img src="${escape(item.src)}" loading="lazy" alt="" role="presentation" />
                                <span>${escape(item.filename)}</span>
                            </div>`;
                },
            }
        });
        $element.data('selectize').setValue($element.data('iconPickerValue'));
    }
})(jQuery);
