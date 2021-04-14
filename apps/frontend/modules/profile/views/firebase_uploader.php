<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Experimental
</button>

<!-- Modal -->
<div class="modal fade"
     id="exampleModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true"
     data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">Info</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="false">Upload</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div id="firebaseui-auth-container"></div>
                        <div id="loader">Loading...</div>
                    </div>
                    <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <input type="file" id="firebaseFiles" multiple accept="image/*"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="authUser">Auth</button>
                <button type="button" class="btn btn-primary" id="upload">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/ui/4.5.1/firebase-ui-auth.js"></script>
<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.5.1/firebase-ui-auth.css"/>
<script>
    const services = (config => {
        const container = document.querySelector('.modal#exampleModal');

        container
            .querySelector('input[type="file"]#firebaseFiles')
            .addEventListener('change', ({ target: { files } }) => {
                for (let i = 0; i < files.length; i++) {
                    uploadFile(files.item(i));
                }
            }, false);

        container
            .querySelector('button#authUser')
            .addEventListener('click', () => {
                authUser();
            }, false);

        firebase.initializeApp(config.app);
        firebase
            .auth()
            .onAuthStateChanged(user => {
                console.table([user]);
            });

        const authUI = new firebaseui.auth.AuthUI(firebase.auth());
        return {
            authUI,
            auth: firebase.auth,
            storage: firebase.storage,
        };
    })({
        app: {
            apiKey: 'AIzaSyD-kZfQJDPq7lKxwcq589miSW0ze870s2s',
            authDomain: 'ukrainian-models-association.firebaseapp.com',
            databaseURL: 'https://ukrainian-models-association.firebaseio.com',
            projectId: 'ukrainian-models-association',
            storageBucket: 'ukrainian-models-association.appspot.com',
            messagingSenderId: '521708243334',
            appId: '1:521708243334:web:dcb6bfcd859936a456c407',
        },
    });

    function authUser() {
        services.authUI.start('#firebaseui-auth-container', {
            callbacks: {
                signInSuccessWithAuthResult: function (authResult, redirectUrl) {
                    console.log('--->', authResult);
                    console.log('---> ', redirectUrl);
                    return true;
                },
                uiShown: function () {
                    console.log('uiShown');
                    document.getElementById('loader').style.display = 'none';
                },
            },
            signInSuccessUrl: '<?=$_SERVER['REQUEST_URI']?>',
            signInFlow: 'popup',
            signInOptions: [
                {
                    provider: firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                    clientId: '521708243334-hd88f7kd0rgud7cddbg22iu0bn9aes6u.apps.googleusercontent.com'
                },
                { provider: firebase.auth.EmailAuthProvider.PROVIDER_ID },
            ],
            tosUrl: '/legal/terms',
            privacyPolicyUrl: '/legal/privacy-policy',
        });
        // services
        //     .auth()
        //     .signInAnonymously()
        //     .catch(console.error);
    }

    function uploadFile(file) {
        services
            .storage()
            .ref()
            .child(`models/${file.name}`)
            .put(file)
            .then(console.log)
            .catch(console.log);
    }

</script>
