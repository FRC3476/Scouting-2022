/*


*/

function OrangeDocument(key){
	this.key = key;
	if(!localStorage.getItem(this.key)){
		localStorage.setItem(this.key , JSON.stringify({}));
	}
}

OrangeDocument.prototype = {
	constructor: OrangeDocument,
	set: function(obj){
		//Load data object
		var saved = JSON.parse(localStorage.getItem(this.key));
		//Load into saved
		for(var k in obj){
			saved[k] = obj[k];
		}
		//Save updated data
		localStorage.setItem(this.key , JSON.stringify(saved));
	},
	get: function(){
		return JSON.parse(localStorage.getItem(this.key));
	}
}

function OrangeCollection (key){
	this.key = key;
	this.documentsKey = this.key + "-documents";
	this.documents = {}
	if(!localStorage.getItem(this.documentsKey)){
		localStorage.setItem(this.documentsKey , JSON.stringify({}));
	}
	else{
		this.documents = JSON.parse(localStorage.getItem(this.documentsKey));
	}
}

OrangeCollection.prototype = {
	constructor: OrangeCollection,
	doc: function(key){
		if(this.documents[key] != 1){
			this.documents[key] = 1;
			localStorage.setItem(this.documentsKey , JSON.stringify(this.documents));
		}
		return new OrangeDocument(key);
	},
	getDocumentKeys: function(){
		var keys = [];
		for(var k in this.documentsKey){
			keys.push(k);
		}
		return keys;
	}
}

function OrangePersist () {
	this.collectionsKey = "orange-collections";
	this.collections = {};
}

OrangePersist.prototype = {
    constructor: OrangePersist,
	initializeApp : function(config){
		/*
			Always initializeApp on start.
			This can be used in future updates to integrate Firebase or other features in our persistance.
		*/
		if(!localStorage.getItem(this.collectionsKey)){
			localStorage.setItem(this.collectionsKey , JSON.stringify({}));
		}
		else{
			this.collections = JSON.parse(localStorage.getItem(this.collectionsKey));
		}
	},
    canStore: function(){
		/*
			Returns true if the browser can store data
		*/
		if(typeof(Storage) !== "undefined"){
			return true;
		}
		else{
			return false;
		}
	},
	collection: function(key){
		if(this.collections[key] != 1){
			this.collections[key] = 1;
			localStorage.setItem(this.collectionsKey , JSON.stringify(this.collections));
		}
		return new OrangeCollection(key);
	},
	getCollectionKeys: function(){
		var keys = [];
		for(var k in this.collections){
			keys.push(k);
		}
		return keys;
	}
}

var orangePersist = new OrangePersist();
