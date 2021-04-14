const Home = (() => {

    const state = new Map();

    const main = document.querySelector('div[id="popularity_rating"]');
    const leftImg = main.querySelector('img[data-side="left"]');
    const leftImgWrapper = leftImg.parentElement;
    const leftBtn = main.querySelector('button[data-side="left"]');
    const rightImg = main.querySelector('img[data-side="right"]');
    const rightImgWrapper = rightImg.parentElement;
    const rightBtn = main.querySelector('button[data-side="right"]');

    document.addEventListener('lock', e => {
        main.style.opacity = .25;
        disableVoteButtons(true);
    }, false);

    document.addEventListener('unlock', () => {
        main.style.opacity = 1;
        disableVoteButtons(false);
    }, false);

    const submitChoice = (object_id) => {
        $.post('/voting/index', {type: 1, votes: 1, object_id}, () => {
            document.dispatchEvent(new Event('unlock'));
        }, 'json');
    };

    const setMemberContext = (side, {userId, photoId}) => {
        main
            .querySelectorAll('*[data-side="' + side + '"]')
            .forEach((node) => {
                const tag = node.tagName.toLowerCase();

                switch (true) {
                    case 'div' === tag:
                        return node.dataset.userId = userId;
                    case 'img' === tag:
                        return node.src = '/imgserve?pid=' + photoId + '&w=320';
                    case 'button' === tag:
                        return node.dataset.objectId = userId;
                }
            });
    };

    const changePair = () => {
        const {value} = state.get('pairs').next();
        const [left, right] = value;

        setMemberContext('left', left);
        setMemberContext('right', right);

        // leftBtn.dataset.objectId = value[0].userId;
        // leftImgWrapper.dataset.userId = value[0].userId;
        // leftImg.src = '/imgserve?pid=' + value[0].photoId + '&w=320';

        // rightBtn.dataset.objectId = value[1].userId;
        // rightImgWrapper.dataset.userId = value[1].userId;
        // rightImg.src = '/imgserve?pid=' + value[1].photoId + '&w=320';
    };

    const fetchPairs = () => {
        const pair = {};
        const set = new Set();

        $.post('/polls/index', {get_pair: 1}, response => {
            for (let i = 0; i < response.length; i += 2) {
                pair.left = response[i];
                pair.right = response[i + 1];

                if (!pair.left || !pair.right) {
                    break;
                }

                set.add([
                    {userId: pair.left.user_id, photoId: pair.left.pid},
                    {userId: pair.right.user_id, photoId: pair.right.pid},
                ]);
            }

            state.set('pairs', set.values());
        }, 'json');
    };

    fetchPairs();

    return {
        handleChoice,
        changePair,
        openProfile,
    };

    function handleChoice(target) {
        const {objectId} = target.dataset;
        document.dispatchEvent(new CustomEvent('lock', {detail: {target}}));
        submitChoice(objectId);
        changePair();
    }

    function openProfile({dataset: {userId}}) {
        window
            .open('/profile?id=' + userId, '_blank')
            .focus();
    }

    function disableVoteButtons(state = true) {
        leftBtn.disabled = rightBtn.disabled = state;
    }
})();
