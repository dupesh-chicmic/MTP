var i_3=100;
var int_3;
var old_3=-1;

var i_2=1000;
var int_2;
var old_2=-1;

//var second = i;
function rotate_3 (spec_3) {
	if (spec_3!=null) {
		i_3=spec_3;
		control_3 (0);
	};

	if (old_3!=-1) document.getElementById (old_3).style.display = 'none';
	else document.getElementById (100).style.display = 'none';

	document.getElementById (i_3).style.display = 'block';


	old_3=i_3;
	i_3++;
        //alert('i_3:'+i_3+' ile_3:'+ile_3);

        if (i_3>=ile_3){i_3=100;}


};

function control_3 (op_3) {
	if (!op_3) {
		document.getElementById ('stop').style.display = 'none';
		document.getElementById ('play').style.display = 'inline';
		clearInterval (int_3);
	}
	else {
		document.getElementById ('stop').style.display = 'inline';
		document.getElementById ('play').style.display = 'none';
		int_3 = setInterval ('rotate_3()', milliseconds_3);
	};
};


function rotate_2 (spec) {
	if (spec!=null) {
		i_2=spec;
		control_2 (0);
	};

	if (old_2!=-1) document.getElementById (old_2).style.display = 'none';
	else document.getElementById (1000).style.display = 'none';

	document.getElementById (i_2).style.display = 'block';
	old_2=i_2;
	i_2++;
	//alert('i_3:'+i_3+' ile_3:'+ile_3);
	if (i_2>=ile_2) i_2=1000;
};

function control_2 (op) {
	if (!op) {
		document.getElementById ('stop').style.display = 'none';
		document.getElementById ('play').style.display = 'inline';
		clearInterval (int_2);
	}
	else {
		document.getElementById ('stop').style.display = 'inline';
		document.getElementById ('play').style.display = 'none';
		int_2 = setInterval ('rotate_2()', milliseconds_2);
	};
};

window.onload=function () {


	int_3 = setInterval ('rotate_3()', milliseconds_3);

	//int_2 = setInterval ('rotate_2()', milliseconds_2);
	//int = setInterval ('rotate()', milliseconds);
        //alert('1'+int);
};
