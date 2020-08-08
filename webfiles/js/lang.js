function ajaxGetSync(uri, mimeType = 'application/json') {

    const httpRequest = new XMLHttpRequest();
    httpRequest.overrideMimeType(mimeType);
    httpRequest.open('GET', uri, false);
    httpRequest.send(null);

    return (httpRequest.status === 200) ?
        JSON.parse(httpRequest.response) :
        [];
}

function getLangCookieValue() {
    const cookieVal = document
        .cookie
        .split('; ')
        .find(cookie => cookie.startsWith('helixlang'))
        .split('=')[1];
    return cookieVal !== null ? cookieVal : 'en';
}

function loadLanguages() {

    this.sanitizeRedundants = (enObj, roObj) => {

        const en = Object.keys(enObj)
            .filter(key => key.includes('js-'))
            .reduce((obj, key) => {
                obj[ key ] = enObj[ key ];
                return obj;
            }, {});

        const ro = Object.keys(roObj)
            .filter(key => key.includes('js-'))
            .reduce((obj, key) => {
                obj[ key ] = roObj[ key ];
                return obj;
            }, {});

        return { en: en, ro: ro };
    };

    const baseURI = `${baseURL}/webfiles/lang`;

    const en = ajaxGetSync(`${baseURI}/en.json`);
    const ro = ajaxGetSync(`${baseURI}/ro.json`);

    return this.sanitizeRedundants(en, ro);
}

const globalLangObj = loadLanguages();