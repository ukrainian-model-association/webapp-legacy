<div class="acenter">
    <input type="file" id="uploadify" multiple="multiple"/>
</div>

<div class="mt10 acenter hide">
    <input type="text" id="uploadify-photos-list"/>
</div>

<div id="uploadify-photos" class="mt10 p10" style="border: 1px solid #ccc; height: 200px; overflow: auto;">
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(() => {
        const inputFile = document.querySelector('input[type="file"]#uploadify');
        const uploadBtn = document.querySelector('input[type="button"]#submit');
        const imagesContainer = document.querySelector('div#uploadify-photos');

        function uploadFile(file) {
            const request = new XMLHttpRequest();
            const formData = new FormData();

            request.open('POST', '/imgserve', true);
            request.upload.onprogress = function (event) {
                console.log(`Отправлено ${event.loaded} из ${event.total} байт`);
            };
            request.onreadystatechange = function () {
                if (request.readyState === 4 && request.status === 200) {
                    const formData = new FormData();
                    formData.set('uid', '<?=$uid?>');
                    formData.set('pid', request.responseText);

                    fetch('/profile/edit?group=photo', { method: 'POST', body: formData })
                        .then(response => response.json())
                        .then(json => {
                            if (json.success) {
                                const image = new Image();
                                image.onload = () => {
                                    const div = document.createElement('div');
                                    div.append(image);
                                    imagesContainer.append(div)
                                }
                                image.src = `/imgserve?pid=${json.pid}`;
                            }
                            // console.log(json);
                            // document.querySelector('img#photo_avatar').setAttribute('src', `/imgserve?pid=${json.pid}`);
                            // document.querySelector('div#photo_avatar_preview > img').setAttribute('src', `/imgserve?pid=${json.pid}`);
                        })
                        .catch(error => console.error('error:', error));
                }
            };

            formData.append('act', 'upload');
            formData.append('key', 'image');
            formData.append('uid', '<?=$uid?>');
            <?php if ('deleted' === request::get_string('filter')) { ?>
            formData.append('type', 'deleted');
            <?php } ?>
            formData.append('image', file);

            request.send(formData);
        }

        function handleChange() {
            for (const file of this.files) {
                uploadFile(file);
            }
        }

        function handleClick() {
            inputFile.click();
        }

        uploadBtn.addEventListener('click', handleClick, false);
        inputFile.addEventListener('change', handleChange, false);
    });
</script>

<script type="text/javascript">
    // var load_form;
    //
    // $(document).ready(function () {
    //
    //     $('#window-add-photo #submit').attr('disabled', true);
    //
    //     load_form = function () {
    //         if (typeof photo.additional != 'undefined') {
    //             photo = {};
    //         }
    //     };

    //$('#uploadify').uploadify({
    //    'uploader': '/uploadify.swf',
    //    'script': '/imgserve',
    //    'fileDataName': 'image',
    //    'buttonImg': '/buttons/upload_photo.png',
    //    'width': '153',
    //    'scriptData':
    //        {
    //            'act': 'upload',
    //            'uid': '<?//=$uid?>//',
    //            'key': 'image',
    //            <?// if(request::get_string('filter') == 'deleted'){ ?>
    //            'type': 'deleted'
    //            <?// } ?>
    //        },
    //    'cancelImg': '/cancel.png',
    //    'transparent': true,
    //    'folder': '/',
    //    'fileDesc': 'jpg; gif; png; jpeg;',
    //    'fileExt': '*.jpg;*.gif;*.png;*.jpeg;',
    //    'auto': true,
    //    'multi': true,
    //    'onError': function (event, queueID, fileObj, response) {
    //    },
    //    'onSelectOnce': function () {
    //        $('#uploadify-photos-list').val('');
    //
    //        $('#uploadify-photos')
    //            .html('')
    //            .append($('<div />').addClass('clear'));
    //    },
    //    'onSelectOnce': function () {
    //        $('#blind-wait').show();
    //        $('#blind-wait').width($('#window-add-photo').width());
    //        $('#blind-wait').height($('#window-add-photo').height());
    //    },
    //    'onComplete': function (event, queueID, fileObj, pid, data) {
    //        var row = $('<div />');
    //
    //        $(row).attr({
    //            'class': 'left mr10 mb10'
    //        })
    //            .css({
    //                'width': '100px',
    //                'height': '100px',
    //                'background': "url('/imgserve?pid=" + pid + "&h=80') no-repeat center",
    //                'border': '1px dotted #ccc'
    //            });
    //
    //        var val = $('#uploadify-photos-list').val();
    //        if (val != '')
    //            val = val + ',' + pid;
    //        else
    //            val = pid;
    //
    //        $('#uploadify-photos-list').val(val);
    //
    //        $("#uploadify-photos > div[class='clear']").before($(row));
    //    },
    //    'onAllComplete': function (event, data) {
    //        $('#window-add-photo #submit').attr('disabled', false);
    //        $('#blind-wait').hide();
    //    }
    //});

    // });
</script>
