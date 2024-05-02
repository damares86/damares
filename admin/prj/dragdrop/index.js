var uid = (function(){
	var id = 1;
	return function(){
		return id +=1;
	};
})();

function TreeNode(config){
	if((this instanceof TreeNode) === false) {
		return new TreeNode(config);
	}
	this.data = null;
	this.children = null;
	this.parent = config.parent;
	this.type = config.type;
	this.id = config.id;
}
TreeNode.prototype = {
	addChild: function(nd, beforeId){
		if(!this.children) {
			this.children = [];
		}
		if(beforeId){
			this.insertChild(nd, beforeId);
		}else{
			this.children.push(nd);
		}
		nd.setParent(this);
	},
	insertChild: function(nd, beforeId) {
		for(var i = 0; i < this.children.length; i++) {
			if(this.children[i].id == beforeId) {
				this.children.splice(i, 0, nd);
				break;
			}
		}
	},
	removeChild: function(nd){
		for(var i = 0; i < this.children.length; i++) {
			if(this.children[i].id == nd.id) {
				this.children.splice(i, 1);
				break;
			}
		}
	},

	getChildById: function(id) {
		var nd = null;
		if(this.children) {
			for(var i = 0; !nd && i < this.children.length; i++) {
				if(this.children[i].id == id) {
					nd = this.children[i];
					break;
				}else{
					nd = this.children[i].getChildById(id);
				}
			}
		}
		return nd;
	},
	setParent: function(p){
		this.parent = p;
	},
	toJSON: function(){
		return this.children[0].toJSON().val;
	}
};


// var BlockTreeNode = (function() {
	function BlockTreeNode (config) {
		if((this instanceof BlockTreeNode) === false) {
			return new BlockTreeNode(config);
		}
		config.type = 'block';
		TreeNode.call(this,config);
	}
	BlockTreeNode.prototype = Object.assign({__proto__: TreeNode.prototype},TreeNode.prototype);
	BlockTreeNode.prototype.toJSON = function(){
		var json = {
			dt: 'block',
			bounds:{

			}
		};
		// var result = TreeNode.prototype.toJSON.call(this, json);
		if(this.children){
			if(/(each|if)/.test(this.children[0].type)) {
				json.components = {};
				this.children.forEach(function(item) {
					var tmp = item.toJSON();
					json.components[tmp.key] = tmp.val;
				});
			}else{
				json.components = [];
				this.children.forEach(function(item) {
					json.components.push(item.toJSON().val);
				});
			}
			
		}
		return {
			key: null,
			val: json
		}

	};
	// return  Fn;
// })();

// var ImageTreeNode = (function() {
	function ImageTreeNode (config) {
		if((this instanceof ImageTreeNode) === false) {
			return new ImageTreeNode(config);
		}
		config.type = 'image';
		TreeNode.call(this,config);
	}
	ImageTreeNode.prototype = Object.assign({__proto__: TreeNode.prototype},TreeNode.prototype);
	ImageTreeNode.prototype.toJSON = function(){
		var json = {
			dt: 'image',
			background:{

			}
		};
		return {
			key: null,
			val: json
		}
	};
// 	return  Fn;
// })();

// var EachTreeNode = (function() {
	function EachTreeNode (config) {
		if((this instanceof EachTreeNode) === false) {
			return new EachTreeNode(config);
		}
		config.type = 'each';
		TreeNode.call(this,config);
	}
	EachTreeNode.prototype = Object.assign({__proto__: TreeNode.prototype},TreeNode.prototype);
	EachTreeNode.prototype.toJSON = function(){
		var key = '{{#each }}'
		var json = {
		};
		// var result = TreeNode.prototype.toJSON.call(this, json);
		if(this.children){
			if(/(each|if)/.test(this.children[0].type)) {
				json = [];
				this.children.forEach(function(item) {
					var tmp = item.toJSON();
					var obj = {};
					obj[tmp.key] = tmp.val;
					json.push(obj);
				});
			}else if(this.children.length === 1){
				json = this.children[0].toJSON().val;
			}else{
				throw new Error('each 放置了多个实体组件');
			}
		}
		return {
			key: key,
			val: json
		}
	};
// 	return  Fn;
// })();

// var IfTreeNode = (function() {
	function IfTreeNode (config) {
		if((this instanceof IfTreeNode) === false) {
			return new IfTreeNode(config);
		}
		config.type = 'if';
		TreeNode.call(this,config);
	}
	IfTreeNode.prototype = Object.assign({__proto__: TreeNode.prototype},TreeNode.prototype);
	IfTreeNode.prototype.toJSON = function(){
		var key = '{{#if }}'
		var json = {
		};
		if(this.children){
			if(/(each|if)/.test(this.children[0].type)) {
				json = [];
				this.children.forEach(function(item) {
					var tmp = item.toJSON();
					var obj = {};
					obj[tmp.key] = tmp.val;
					json.push(obj);
				});
			}else if(this.children.length === 1){
				json = this.children[0].toJSON().val;
			}else{
				throw new Error('if 放置了多个实体组件');
			}
			
		}
		return {
			key: key,
			val: json
		}
	};
// 	return  Fn;
// })();

function Tree(){
	this.root = new TreeNode({
		id: uid(),
		type: null
	});
}
Tree.prototype = {
	addChild : function(nd, beforeId){
		this.root.addChild(nd, beforeId);
	},
	removeChild: function(nd){
		this.root.removeChild(nd);
	},
	getChildById: function(id) {
		return this.root.getChildById(id)
	},
	createChild: function(type, id){
		var NodeFn = null;
		switch(type){
			case 'block': NodeFn =  BlockTreeNode;break;
			case 'each': NodeFn =  EachTreeNode;break;
			case 'if': NodeFn =  IfTreeNode;break;
			case 'image': NodeFn =  ImageTreeNode;break;
		}
		var nd = NodeFn.call(null, {
			id: id
		});
		// this.addChild(nd);
		return nd;
	},
	toJSON: function(){
		return this.root.toJSON();
	}
};

var compTree = new Tree();


var compList = document.querySelector('#compList');
var treeView = document.querySelector('#treeView');

treeView.dataset.id = compTree.root.id;


var drake = dragula([compList, treeView],{
  isContainer: function (el) {
    return el.classList.contains('dropCnt');
  },
  copy: function(el) {
  	return el.classList.contains('compType') && el.parentNode.classList.contains('compList');
  },
  accepts: function (el, target, source, sibling) {
  	// console.log(arguments)
    if(!target.classList.contains('dropCnt')) {
    	return false;
    }
    // var type = el.dataset.type;
    // if(/(each|if)/.test(type) && target.dataset.type != 'block') {
    // 	return false;
    // }
    return true; // elements can be dropped in any of the `containers` by default
  },
});

// console.log(drake.containers)

function getParentDiv(nd){
	var p = nd;
	do{
		p = p.parentNode;
	}while(!p.classList.contains('droppedComp') && !p.classList.contains('treeView') )
	return p;
}
function getSiblingId(sibling){
	return sibling ? sibling.dataset.id : null;
}

drake.on('drop', function(el, target, source, sibling){
	
	
	if(target && source) {
		/*
		<div class="droppedComp"><div class="compType dropCnt" data-type="block">block</div></div>
		*/
		var tmp = null;
		var newChild = null;
		var newId = uid();
		var pId = null;

		if(!el.classList.contains('droppedComp')) {
			tmp = document.createElement('div');
			tmp.classList.add('droppedComp');
			tmp.dataset.id = newId;

			el.parentNode.insertBefore(tmp, el);
			tmp.appendChild(el);
			el.classList.add('dropCnt');

			newChild = compTree.createChild(el.dataset.type, newId);
			if(tmp.parentNode.classList.contains('treeView')) {
				// newChild.setParent(compTree.root);
				compTree.root.addChild(newChild ,getSiblingId(sibling));
			}else{
				compTree.getChildById(getParentDiv(target).dataset.id).addChild(newChild,getSiblingId(sibling));
			}

		}else{
			var child = compTree.getChildById(el.dataset.id);
			
			compTree.getChildById(getParentDiv(source).dataset.id).removeChild(child);
			compTree.getChildById(getParentDiv(target).dataset.id).addChild(child, getSiblingId(sibling));
			// var pNode = compTree.getChildById(tmp.dateset.id);
		}

		// console.log(target.dataset.id)

		// drake.containers.push(el);
		console.log(JSON.stringify(compTree.toJSON()));
	}
});



var demoJson = {"dt":"block","bounds":{},"components":[{"dt":"block","bounds":{},"components":[{"dt":"image","background":{}}]},{"dt":"block","bounds":{},"components":{"{{#each }}":[{"{{#if }}":{}},{"{{#if }}":{}}]}}]}

function createTreeNodeFromJson(parent, json){
	var NodeFn = null;
	var nd = null;
	var isCommand = false;
	switch(json.dt){
		case 'block': NodeFn =  BlockTreeNode;break;
		case 'image': NodeFn =  ImageTreeNode;break;
	}
	if(!NodeFn){
		isCommand = true;
		var keys = Object.keys(json);
		
		if(keys && keys[0]){
			if(/^{{#each/.test(keys[0])) {
				NodeFn = EachTreeNode;
			}else if(/^{{#if/.test(keys[0])){
				NodeFn = IfTreeNode;
			}
		}
	}
	if(NodeFn){
		nd = NodeFn.call(null, {
			id: uid()
		});
	}
	if(nd) {
		parent.addChild(nd);
		if(json.components) {
			if(Array.isArray(json.components)) {
				json.components.forEach(function(item, i){
					createTreeNodeFromJson(nd, item);
				});
			}else{
				createTreeNodeFromJson(nd, json.components);
			}
		}else if(isCommand){
			if(Array.isArray(json[keys[0]])) {
				json[keys[0]].forEach(function(item, i){
					createTreeNodeFromJson(nd, item);
				});
			}
		}
	}
	return nd;
}

function createTreeFromJson(json){
	var compTree = new Tree();
	createTreeNodeFromJson(compTree.root, json);
	return compTree;
}
var aTree = createTreeFromJson(demoJson);
console.log(JSON.stringify(aTree.toJSON()))

