var t;
function goTo(func)
{
    sProg();
    //alert(func);
    eval(func + "()");    
    t = setTimeout("eProg()",2000);    
}

function sProg(aType)
{
    document.getElementById("progressImg").style.display = 'block';
}

function eProg()
{
    document.getElementById("progressImg").style.display = 'none';
    clearTimeout(t)
}