function calculateDivHeight(srcDivId, destDivId)
{
    sDiv=document.getElementById(srcDivId);
    dDiv=document.getElementById(destDivId);
    var h =sDiv.clientHeight;
    dDiv.style.height = h+"px";
}

function hMenuSwitch (name, on)
{
    left=document.getElementById('hover_left_'+name);
    center=document.getElementById('hover_center_'+name);
    right=document.getElementById('hover_right_'+name);
    left.className='hover hover_sides hover_left_'+on;
    center.className='hover hover_center hover_center_'+on;
    right.className='hover hover_sides hover_right_'+on;
}