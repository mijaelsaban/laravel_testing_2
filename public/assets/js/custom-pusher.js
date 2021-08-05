$(function () {
    showServerResponse(
        '.listen',
        '/storage/imported_transactions.html'
    );

    function showServerResponse(validationClass, pathToFile)
    {
        if ($(validationClass).length) {
            $('#alrt-msg').text('Importing transactions...').addClass('broadcast')
            $('#msg-wraper').fadeIn('slow');
            let counter = 0
            let interval = setInterval(function () {
                $.get(pathToFile + '?' + Date.now(), function (data) {
                    const uploadingInformation = $('.uploading-information');
                    uploadingInformation.show();
                    $('.uploading-information .counter').html(data);
                    const timer = $('.uploading-information .timer');
                    timer.html(counter++ + '\'s')
                    if (data.length > 1) {
                        $('.validating').addClass('line-through')
                        $('.importing').removeClass('d-none')
                    }

                    if ($('.is-success').length || (data.length < 1 && timer.text() === '300\'s')) {
                        uploadingInformation.removeClass('alert-warning');
                        clearInterval(interval);
                    }
                }, 'text');
            }, 1000)
        }
    }
});
