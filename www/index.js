var channel = '';
var t = document.getElementById('temperature');
	

var pubnub = PUBNUB.init({
        subscribe_key: 'sub-c-4799f9ac-7c74-11e5-a643-02ee2ddab7fe'
        publish_key: 'pub-c-d9fdbbc2-318e-498a-a09d-2bf276df3929',
    });

function initialize() {
    bindEvents();
}
function bindEvents() {

    document.addEventListener('deviceready', main, false);
}

function main() {

    var pushNotification = window.plugins.pushNotification;
alert(pushNotification);
   pushNotification.register(successHandler, errorHandler, {'senderID':'1010018101342','ecb':'onNotificationGCM'});

  					alert('hello');
}

function successHandler(result) {

    console.log('Success: '+ result);
}

function errorHandler(error) {

    console.log('Error: '+ error);
}

function onNotificationGCM(e) {

    switch( e.event ){
        case 'registered':
            if ( e.regid.length > 0 ){
                console.log('regid = '+e.regid);
                registerDevice(e.regid);
            }
        break;

        case 'message':
            console.log(e);
            if (e.foreground){
                alert('The room temperature is set too high')
            }
        break;

        case 'error':
            console.log('GCM error = '+e.msg);
        break;

        default:
          console.log('An unknown GCM event has occurred');
          break;
    }
}

// Publish the channel name and regid to PubNub
function registerDevice(regid) {

    channel = regid.substr(regid.length - 8).toLowerCase();

    var c = document.querySelector('.channel');
    c.innerHTML = 'Your Device ID: <strong>' + channel + '</strong>';
    c.classList.remove('blink'); 

    pubnub.publish({
        channel: channel,
        message: {
            regid: regid
        }
    });

    pubnub.subscribe({
        channel: channel,
        callback: function(m) {
            console.log(m);
            t.classList.remove('gears');
            if(m.setting) {
                t.textContent = m.setting + '°';
            }
        }
    });  
}


initialize();

