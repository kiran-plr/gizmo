(function ($) {
    var path_url = [];
    $.fn.filemanager = function (type, options) {
        type = type || 'file';

        this.on('click', function (e) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var target_input = $('#' + $(this).data('input'));
            var target_preview = $('#' + $(this).data('preview'));
            var oldUrl = $('#thumbnail').val();
            oldUrl = oldUrl.split(',');
            window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                var file_path = items.map(function (item) {
                    return item.url;
                }).join(',');

                // set the value of the desired input to image url
                target_input.val('').val(file_path).trigger('change');

                // clear previous preview
                target_preview.html('');

                // set or change the preview image src
                items.forEach(function (item) {
                    target_preview.append(
                        $('<img>').css('height', '5rem').attr('src', item.thumb_url)
                    );

                    path_url.push(item.url);
                });

                var mergedUrl = $.merge(oldUrl, path_url);

                path_url = [];
                oldUrl = [];
                $('.productImagePre').html('');
                if (mergedUrl != '') {
                    $.each(mergedUrl, function (index, value) {
                        if (value != '') {
                            $('.productImagePre').append('<div class="col" wire:ignore>' +
                                '<div class="plus-box mt-3">' +
                                '<span>' +
                                '<div class="icon"><li class="ui-state-default"><i class="fa fa-plus"></i> <div id="" class="imagePreview" style="margin-top:10px;margin-bottom:10px;max-height:100px;width:125px;"> ' +
                                '<img class="imageCount product-image" src="' + value + '"><div class="overlay"><a href="javascript:;" class="icon remove_thumb" title="Remove"><i style="color:red;" class="fa fa-trash"></i></a>' +
                                '</div> </div> </li></div></span>' +
                                '</div>' +
                                '</div>');
                        }
                    });
                    $('#thumbnail').val(mergedUrl);
                    window.livewire.emit('setPhotos', mergedUrl);
                }
                $('.removeCateImg').remove();
                $('.fa-plus').remove();
                // trigger change event
                target_preview.trigger('change');
            };
            return false;
        });
        $(document).on('click', '.remove_thumb', function () {
            var removeImagePreview = $(this).parent().parent().parent().parent().parent().parent().parent();
            var thisUrl = $(this).parent().parent().children('img').attr('src');
            var url = window.location.origin;
            var thumbUrl = $('#thumbnail').val();
            thisUrl = thisUrl.replace(url, '');
            var found = jQuery.inArray(thisUrl, thumbUrl);
            if (found >= 0) {
                path_url.splice(found, 1);
            }
            path_url = path_url.splice(thisUrl, 1);
            thumbUrl = thumbUrl.replace(thisUrl, '');
            $('#thumbnail').val(thumbUrl);
            removeImagePreview.remove();
        })
    }

})(jQuery);
