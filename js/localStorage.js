// JavaScript Document
function checkLocalStorageSupport() {
  try {
    return 'localStorage' in window && window['localStorage'] !== null;
  } catch (e) {
    return false;
  }
}

function saveData(key,data){
	 if(checkLocalStorageSupport())
     {
          window.localStorage.setItem(key,data);
     }
}

function loadData(key){
     if(checkLocalStorageSupport())
     {
          var data = window.localStorage.getItem(key);
          if(data != null)
          {
               return data;  
          }         
     }
}

function clearData(){
	if(checkLocalStorageSupport())
     {
          window.localStorage.clear();    
     }
}