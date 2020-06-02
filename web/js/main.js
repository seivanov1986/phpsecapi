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

        var data = {
            password: rsa.encrypt('123456'),
            body: ''
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

/*
TODO:
1. function send data
1.1 generate password
1.2 crypt data by AES and password
1.3 crypt password by public_key
1.4 send data and password to server
*/

/*
TODO:
1. function receive data
1.1 decrypt password
1.2 decrypt data by AES and password
*/

/*
AES_Init();

var block = new Array(16);
for(var i = 0; i < 16; i++)
    block[i] = 0x11 * i;

var key = new Array(32);
for(var i = 0; i < 32; i++)
    key[i] = i;

AES_ExpandKey(key);
AES_Encrypt(block, key);

AES_Done();
*/