import {
	setDoc,
	getDocs,
	collection,
	doc
} from 'https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore.js';

import { db } from './firebase.js';

/* Custom Dragula JS */

/*

Set All Times First Time Using This Script in picklist.php

<?php
                    include("databaseLibrary.php");
                    $teamList = getEventTeams();
                    foreach ($teamList as $teamNumber) {
                        echo ("
                        <div class='card mb-3 task' id='' style='max-width: 550px; margin-top: 25px'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-8'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $teamNumber . "</h3>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    ");
                    }
                    ?>

*/

getDocs(collection(db, 'all-teams')).then(snapshot => {
	snapshot.forEach(doc => {
		console.log(doc.data().teams);
		document.getElementById('all-teams').innerHTML = doc.data().teams;
	});
});

getDocs(collection(db, 'defense-teams')).then(snapshot => {
	snapshot.forEach(doc => {
		console.log(doc.data().teams);
		document.getElementById('defense-teams').innerHTML = doc.data().teams;
	});
});

getDocs(collection(db, 'dnp-teams')).then(snapshot => {
	snapshot.forEach(doc => {
		console.log(doc.data().teams);
		document.getElementById('dnp-teams').innerHTML = doc.data().teams;
	});
});

getDocs(collection(db, 'offense-teams')).then(snapshot => {
	snapshot.forEach(doc => {
		console.log(doc.data().teams);
		document.getElementById('offense-teams').innerHTML = doc.data().teams;
	});
});

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
		console.log(el);
		console.log(target);
		console.log(source);
		console.log(el.id);
		el.removeAttribute('id');
		el.id += target.id;
		console.log(el.id);
		console.log(el);
		console.log(document.getElementById(el.id).innerHTML);
		console.log(document.getElementById('all-teams').innerHTML);
		try {
			setTimeout(() => {
				setDoc(doc(db, 'all-teams', 'teams'), {
					teams: document.getElementById('all-teams').innerHTML
				}).then(() => {
					console.log('All Teams Updated');
				});
				setDoc(doc(db, 'offense-teams', 'teams'), {
					teams: document.getElementById('offense-teams').innerHTML
				}).then(() => {
					console.log('Offense Teams Updated');
				});
				setDoc(doc(db, 'defense-teams', 'teams'), {
					teams: document.getElementById('defense-teams').innerHTML
				}).then(() => {
					console.log('Defense Teams Updated');
				});
				setDoc(doc(db, 'dnp-teams', 'teams'), {
					teams: document.getElementById('dnp-teams').innerHTML
				}).then(() => {
					console.log('DNP Teams Updated');
				});

				setDoc(doc(db, source.id, 'teams'), {
					teams: document.getElementById(source.id).innerHTML
				});
			}, 5000);
		} catch (e) {
			console.error('Error adding document: ', e);
		}
		// setElements(el.id, document.getElementById(el.id).children);
	});
