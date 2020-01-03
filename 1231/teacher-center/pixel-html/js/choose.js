
        function $(obj){return document.getElementById(obj);} 
        function show(objid) {$(objid).style.display='inline';} 
        function hidden(objid) {$(objid).style.display='none';} 
        function doit(){ 
        var sel_val=$('sel').value; 
        if (sel_val=='') {hidden('a1');hidden('a2');} 
        if (sel_val==0) {hidden('a1');hidden('a2');} 
        if (sel_val==1) {show('a1');hidden('a2');} 
        if (sel_val==2) {show('a2');hidden('a1');} 
        } 
