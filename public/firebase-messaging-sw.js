/*

Give the service worker access to Firebase Messaging.

Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.

*/

importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');

importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

   

/*

Initialize the Firebase app in the service worker by passing in the messagingSenderId.

* New configuration for app@pulseservice.com

*/

firebase.initializeApp({
    apiKey: "AIzaSyDHMjMsel6KaGu9egrU-A42h02id2kQ_bY",
    authDomain: "bhargava-a964e.firebaseapp.com",
    projectId: "bhargava-a964e",
    storageBucket: "bhargava-a964e.appspot.com",
    messagingSenderId: "513034999401",
    appId: "1:513034999401:web:8b265431c04a17438074f8",
    measurementId: "G-N3VTKL9MKP"
});

  

/*

Retrieve an instance of Firebase Messaging so that it can handle background messages.

*/

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {

    console.log(

        "[firebase-messaging-sw.js] Received background message ",

        payload,

    );

    /* Customize notification here */

    const notificationTitle = "Background Message Title";

    const notificationOptions = {

        body: "Background Message body.",

        icon: "/itwonders-web-logo.png",

    };

  

    return self.registration.showNotification(

        notificationTitle,

        notificationOptions,

    );

});