new class {
    constructor() {
        console.log(app)
    }
};

window.$$ = new Map();

window.$$.set('profile.index.admin_block.top50_19', () => {

    const httpClient = new class {
        constructor() {
            this.headers = new Headers({
                Accept: '*/*',
                'Access-Control-Allow-Methods': ['GET', 'POST', 'OPTIONS', 'PUT', 'PATCH', 'DELETE'].join(', '),
                'Access-Control-Allow-Headers': ['origin', 'X-Requested-With', 'content-type', 'accept'].join(', '),
                'Access-Control-Allow-Credentials': 'true'
            });
        }

        createRequest(baseUrl) {
            return Object.assign({}, this, {
                baseUrl
            })
        }

        send(method, url) {
            return fetch(this.url, this.options)
                .then(response => response.json());
        }
    };

    const api = new class {
        constructor() {
            this.client = httpClient.createRequest(`/api/profiles/`)
        }
    };

    return new class {
        constructor() {


            document
                .querySelector('input[id="admin_block[top50_19]"]')
                .addEventListener('change', this.handleChange.bind(this));
        }

        handleChange(event) {
            console.log(this, event);
        }
    };

});