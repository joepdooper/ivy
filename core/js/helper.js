// Javascript item
var item = {};

// Javascript hooks
var hooks = {};

function add_to_function(name, func) {
  if(!hooks[name]) hooks[name] = [];
  hooks[name].push(func);
}

function call_my_function(name,params){
  if(hooks[name])
     hooks[name].forEach(func => func(params));
}