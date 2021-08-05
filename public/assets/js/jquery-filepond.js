$(function () {
    'use strict';

    $(function () {
        const filepond = FilePond.create(
            document.querySelector('.filepond'),
            {
                acceptedFileTypes: "text/csv, application/csv, application/vnd.ms-excel",
                labelIdle: `Drag & Drop your CSV or <span class="filepond--label-action">Browse</span>`,
                server: {
                    url: '/transactions',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    process: {
                        method: 'POST',
                        onerror: (res) => {
                            return res
                        }
                    }
                },
                allowRevert: false,
                onprocessfile: (error, file) => {
                    if (!error) {
                        setTimeout(function () {
                            filepond.removeFile(file.id);
                            console.log('file added to queue');
                            $('#alrt-msg').text('Importing transactions...').addClass('broadcast')
                            $('#msg-wraper').fadeIn('slow');
                        }, 1300);
                    } else {
                        console.log('you got an error', error);
                    }
                }
            }
        );
        $('.filepond--credits').remove();
    });
});
