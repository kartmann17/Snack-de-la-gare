function checkCookieConsent() {
    if (document.cookie.indexOf('cookies_accepted=true') === -1) {
        document.getElementById('cookie-consent-banner').style.display = 'block';
    }
}

function acceptCookies() {
    document.cookie = "cookies_accepted=true; path=/; max-age=31536000";
    document.getElementById('cookie-consent-banner').style.display = 'none';
}


checkCookieConsent();