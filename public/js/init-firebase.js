var firebaseConfig = {
	apiKey: "{{env('APIKEY')}}",
	authDomain: "{{env('AUTHDOMAIN')}}",
	databaseURL: "{{env('DATABASEURL')}}",
	projectId: "{{env('PROJECTID')}}",
	storageBucket: "{{env('STOREBUCKET')}}",
	messagingSenderId: "{{env('MESSAGINGSENDERID')}}",
	appId: "{{env('APPID')}}",
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
var database = firebase.database();