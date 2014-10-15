// insert external js file:

// define global var
var t, preX, preY;
var x=2;
var y=0;
var gameArg = [ 0 , 1 ] ;
// gameArg: 0=>blockType; 1=>level; 
// game launch
$(function(){
	for(i=0;i<len;i++)
    {
        ciBlock( blockMap(y, x), i );
		logBlock( blockMap(y, (width-1)), i );
		y++;
		lineBlock( blockMap(y, x), 1 );
		y++;
    }
	$("[log]").css({"background-color":"#DDCDEB" ,"font-size":"100%","text-overflow":"ellipsis","white-space":"nowrap","text-align":"left","width":"50%" });
	$("[line]").css({"background-color":"#FFFFFF" ,"line-height":"70%","font-size":"70%","text-align":"center" });
	$("[commit]").css({"background-color":"red" ,"font-size":"70%" ,"text-align":"center"});
});

function blockMap(a, b){	// get the table data DOM (x,y)
    var point1 = "td.data" + a + '-' + b ;
    //var point = point1 + ','+ point2 + ','+ point3+ ','+ point4 ;
    return point1;
}

function ciBlock(point, num){	// commit td
    $(point).attr("commit", git[num]);
	$(point).text('*');
}

function logBlock(point, num){    // new table data for log  [0]+git[num][1]+
	var log = "<td log='"+git[num]+"'>"+git[num]+' - '+subject[num]+"</td>";
	var logtr = $(point).parent();
	var logtd = $(logtr).append(log);
}

function lineBlock(point, type){	// draw log line
	$(point).attr("line", type);
	switch(type){
		case 1:
			$(point).text('|');
			break;
		case 2:
			$(point).attr('/');
			break;
		case 3:
			$(point).attr('\\');
			break;
	}
}


