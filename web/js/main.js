var data = { 'public_key': '' }
var rsa = new RSAKey();

fetch("http://localhost/handShake", {
    method: 'POST',
    body: JSON.stringify(data)
}).then((e) => {

    e.json().then(function(data) {

        console.log('server_public_key');
        console.log(data.server_public_key);

        rsa.setPublic(data.server_public_key, data.server_public_key_2);

    }).catch(err => {
        console.log(err);
    });

}).catch(error => {
    console.log('request failed', error);
});

document.addEventListener("DOMContentLoaded", function(){
    document.querySelector('#send').addEventListener('click', function(){

        var password = '123456';
        var message = 'My string - Could also be an JS array/object';

        var iv = 'a1a2a3a4a5a6a7a8b1b2b3b4b5b6b7b8';
        var key = CryptoJS.SHA256(password).toString();

        var keyBytes = CryptoJS.enc.Hex.parse(key);
        var ivBytes = CryptoJS.enc.Hex.parse(iv);

        var encrypted_body = CryptoJS.AES.encrypt(message, keyBytes, {
            iv: ivBytes,
        }).ciphertext.toString(CryptoJS.enc.Base64);

        console.log(encrypted_body);

        var data = {
            password: rsa.encrypt(password),
            body: encrypted_body
        };

        fetch("http://localhost/test", {
            method: 'POST',
            body: JSON.stringify(data)
        }).then((e) => {
            e.json().then(function(data) {
                console.log(data);
            }).catch(err => {
                console.log(err);
            });
        }).catch(error => {
            console.log('request failed', error);
        });
    });
});