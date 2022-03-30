import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js';
import { getFirestore } from 'https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore.js';

const firebaseConfig = {
	apiKey: 'AIzaSyDk-Ld9C7znNsjQG-V_h0zZiusXULVMysI',
	authDomain: 'codeorangescouting.firebaseapp.com',
	projectId: 'codeorangescouting',
	storageBucket: 'codeorangescouting.appspot.com',
	messagingSenderId: '605357210790',
	appId: '1:605357210790:web:690a2acebadc6115d94867',
	measurementId: 'G-4EDJ9CMDF2'
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

export { db };
