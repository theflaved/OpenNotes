function loginFailEvent(){
    if(getCookie("attempts") == null){
        setCookie("attempts",0);
    }
    var flag = parseInt(getCookie("attempts"));
    if(flag >= 3) {
        setCookie("attempts", 3, 60);
        UIkit.modal.alert('Too much attempts, try again or <a href="register.php">register</a>');
        return;
    }
    setCookie("attempts", flag + 1);
    UIkit.modal.alert('Wrong username or password! Try again or <a href="register.php">register</a>');
    return;
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

/*function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}*/

function setCookie(name, value, expires, path, domain, secure) {
    expires instanceof Date ? expires = expires.toGMTString() : typeof(expires) == 'number' && (expires = (new Date(+(new Date) + expires * 1e3)).toGMTString());
    var r = [name + "=" + escape(value)], s, i;
    for(i in s = {expires: expires, path: path, domain: domain}){
        s[i] && r.push(i + "=" + s[i]);
    }
    return secure && r.push("secure"), document.cookie = r.join(";"), true;
}


