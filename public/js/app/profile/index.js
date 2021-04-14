(() => {
    const avatarDiv = document.querySelector('div#avatar'),
        portfolioDiv = document.querySelector('div#portfolio');

    if (null !== portfolioDiv) {
        portfolioDiv
            .querySelectorAll(':scope > img')
            .forEach(e => {
                e.addEventListener('click', ({ target: { dataset: { photoId } } }) => {
                    changePhoto(photoId);
                });
            });
    }

    function changePhoto($photoId) {
        const nextImg = new Image(),
            prevImg = avatarDiv.querySelector(':scope > img');

        $(avatarDiv).css({
            opacity: 0,
        });

        nextImg.classList = prevImg.classList;
        nextImg.alt = prevImg.alt;
        nextImg.onload = function () {
            avatarDiv.removeChild(prevImg);
            avatarDiv.appendChild(nextImg);
            $(avatarDiv).animate({
                opacity: 1,
            }, 256);
        };
        nextImg.src = '/imgserve?pid=' + $photoId + '&w=480';
    }
})();

((adminDiv) => {
    if (!adminDiv) return;
    const
        uid = adminDiv.dataset['uid'],
        statusTypeSelect = adminDiv.querySelector('select[id="statusType"]'),
        personTypeSelect = adminDiv.querySelector('select[id="personType"]'),
        successfulModel = adminDiv.querySelector('input[id="successfulModel"]'),
        memberOfAssociation = adminDiv.querySelector('input[id="memberOfAssociation"]'),
        isHiddenCheckbox = adminDiv.querySelector('input[id="isHidden"]'),
        hasConversationAccess = adminDiv.querySelector('input[id="hasConversationAccess"]');

    statusTypeSelect.addEventListener('change', ({ target: { value } }) => {
        const payload = {
            id: uid,
            type: 'delete',
            submit: 1,
        };

        $.post('/adminka/successfull', payload, () => {
            if (value) {
                $.post('/adminka/successfull', {
                    submit: 1,
                    id: uid,
                    type: 'add',
                    mt: value,
                }, r => {
                    console.table(r);
                }, 'json');
            }
        }, 'json');
    });

    personTypeSelect.addEventListener('change', ({ target: { value } }) => {
        $.post('/adminka/user_manager', {
            act: 'status_change',
            user_id: uid,
            status: value,
        }, r => {
            console.log(r);
        }, 'json');
    });

    successfulModel.addEventListener('change', ({ target: { checked } }) => {
        $.post(`/api/profiles/${uid}/extra`, {
            value: checked ? 1 : 0,
            target: 'successful_model',
        }, payload => {
            console.log(payload);
        });
    });

    memberOfAssociation.addEventListener('change', ({ target: { checked } }) => {
        $.post(`/api/profiles/${uid}/extra`, {
            value: checked ? 1 : 0,
            target: 'member_of_association',
        }, payload => {
            console.log(payload);
        });
    });

    isHiddenCheckbox.addEventListener('change', ({ target }) => {
        $.post('/adminka/user_manager', {
            act: 'modify',
            user_id: uid,
            hidden: target.checked ? 1 : 0,
        }, function (data) {
            console.log(data);
        }, 'json');
    });

    hasConversationAccess.addEventListener('change', ({ target }) => {
        $.post('/adminka/user_manager', {
            act: 'can_write',
            user_id: uid,
            can_write: target.checked ? 1 : 0,
        }, function (data) {
            console.log(data);
        }, 'json');
    });

    const form = new Form('form-smi');
    form.onSuccess = function (response) {
        if (response.success) {
            $('#msg-success-smi')
                .show()
                .css('opacity', '0')
                .animate({
                    opacity: 1,
                }, 256, function () {
                    setTimeout(function () {
                        $('#msg-success-smi').animate({
                            opacity: 0,
                        }, 256, function () {
                            $(this).hide();
                            $('#window-smi').hide();
                            window.location.reload();
                        });
                    }, 1000);
                });
        } else {
            $('#msg-error-smi')
                .show()
                .css('opacity', '0')
                .animate({
                    opacity: 1,
                }, 256, function () {
                    setTimeout(function () {
                        $('#msg-error-smi').animate({
                            opacity: 0,
                        }, 256, function () {
                            $(this).hide();
                        });
                    }, 2000);
                });
        }
    };

    $('button#submit', $('form#form-smi')).click(function () {
        form.data['act'] = 'add_smi';
        form.send();
    });

    $('button[id^="remove-smi-"]').click(function () {
        if (confirm('Вы действительно хотите удалить запись?')) {
            const id = $(this).attr('id').split('-')[2];
            $.post('/profile?id=' + uid, {
                act: 'remove_smi',
                smi_id: id,
            }, function (response) {
                if (response.success) {
                    $('button#remove-smi-' + id)
                        .parent()
                        .remove();
                }
            }, 'json');
        }
    });
})(document.querySelector('div#admin'));
(selectors => {
    const $object2FormData = (() => {
        const object2FormData = (formData, data, parentKey) => {
            if (data && typeof data === 'object' && !(data instanceof Date)) {
                Object.keys(data).forEach(key => {
                    object2FormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                });
            } else {
                const value = data == null ? '' : data;

                formData.append(parentKey, value);
            }

            return formData;
        };

        return object2FormData;
    })();

    const milestone = document.querySelector('div#milestone');
    const uid = milestone.dataset['uid'];
    const value = parseInt(milestone.dataset['value']);

    const $fetch = (() => {
        const headers = new Headers({
            Accept: '*/*',
            'Access-Control-Allow-Methods': [ 'GET', 'POST', 'OPTIONS', 'PUT', 'PATCH', 'DELETE' ].join(', '),
            'Access-Control-Allow-Headers': [ 'origin', 'X-Requested-With', 'content-type', 'accept' ].join(','),
            'Access-Control-Allow-Credentials': 'true',

        });

        return (method, url, body) => {
            return fetch(url, { method, headers, body: $object2FormData(new FormData, body) })
                .then(response => response.json());
        };
    })();

    const buttonsGroup = document.querySelector(selectors),
        buttons = buttonsGroup.querySelectorAll(':scope > button.btn'),
        handleClick = ({ target: { classList, value } }) => {
            $fetch('POST', '/api/profiles/' + uid + '/milestones', {
                milestone: value,
            }).then(r => {
                classList.remove('btn-outline-secondary');
                classList.add('btn-secondary');
            });

            buttons.forEach(({ classList }) => {
                classList.remove('btn-secondary');
                classList.add('btn-outline-secondary');
            });
        };

    buttons.forEach(b => {
        b.addEventListener('click', handleClick);
    });
    buttons.item(value).click();

})('div#milestone.btn-group');
