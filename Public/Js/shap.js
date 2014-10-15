// shap array data
var I1_block = [ [0,0], [0,2], [0,4], [0,6] ];
var I2_block = [ [0,0], [1,0], [2,0], [3,0] ];

var show_block = I1_block;

function drag( a, b, shap, flag){
    var point = blockMap(a, b, shap);
    switch(flag){
        case 0:    // tag = 0; clean block
            cleanBlock(point);
            break;
        case 1:    // tag = 1; drag block
            moveBlock(point);
            break;
        case 2:    // tag = 2; lock block
            lockBlock(point);
            break;
    }
}

function cleanBlock(point){ if( y>=0 ) $(point).css("background-color", "#A7C942"); }

function moveBlock(point){  
    if( ! crash(point) ){
        $(point).css("background-color", "#FFFFFF");
    }
    else{
        var preBlock = blockMap((y+preY), (x+preX), show_block);
        lockBlock(preBlock);
        y=-1;
    }
}

function lockBlock(point){
    $(point).css("background-color", "red");
    $(point).attr("lock", "1");
}

function blockMap(a, b, shap){
    var point1 = "td.data" + (a+shap[0][0]) + '-' + (b+shap[0][1]) ;
    var point2 = "td.data" + (a+shap[1][0]) + '-' + (b+shap[1][1]) ;
    var point3 = "td.data" + (a+shap[2][0]) + '-' + (b+shap[2][1]) ;
    var point4 = "td.data" + (a+shap[3][0]) + '-' + (b+shap[3][1]) ;
    var point = point1 + ','+ point2 + ','+ point3+ ','+ point4 ;
    
    return point;
}

function crash(point) {
    var pointArray = point.split(",");
    var hit = ( $(pointArray[0]).attr("lock") | $(pointArray[1]).attr("lock") /
            $(pointArray[2]).attr("lock") | $(pointArray[3]).attr("lock") ) ;
    $("div[name='log']").text(hit);
    return hit;

}


