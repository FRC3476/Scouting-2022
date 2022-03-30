import {
	setDoc,
	addDoc,
	collection,
	doc
} from 'https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore.js';

import { db } from './firebase.js';

/* Custom Dragula JS */

dragula([
	document.getElementById('all-teams'),
	document.getElementById('offense-teams'),
	document.getElementById('defense-teams'),
	document.getElementById('dnp-teams')
])
	.on('drag', function (el) {
		console.log('Moving');
	})
	.on('drop', function (el, target, source) {
		const element = el.innerHTML;
		const targetElement = target.innerHTML;
		console.log(el);
		console.log(target);
		console.log(source);
		console.log(el.id);
		el.removeAttribute('id');
		el.id += target.id;
		console.log(el.id);
		console.log(el);
		console.log(document.getElementById(el.id).innerHTML);
		try {
			// const docRef = addDoc(collection(db, el.id), {
			// 	teams: document.getElementById(el.id).innerHTML
			// });
			setDoc(doc(db, el.id, 'teams'), {
				teams: document.getElementById('all-teams').innerHTML
			});
			setDoc(doc(db, el.id, 'teams'), {
				teams: document.getElementById('offense-teams').innerHTML
			});
			setDoc(doc(db, el.id, 'teams'), {
				teams: document.getElementById('defense-teams').innerHTML
			});
			setDoc(doc(db, el.id, 'teams'), {
				teams: document.getElementById('dnp-teams').innerHTML
			});
			setDoc(doc(db, source.id, 'teams'), {
				teams: document.getElementById(source.id).innerHTML
			});
			console.log('Document written');
		} catch (e) {
			console.error('Error adding document: ', e);
		}
		// setElements(el.id, document.getElementById(el.id).children);
	});
